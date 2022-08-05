<?php

namespace SmartpingApi\Service;

use Doctrine\Common\Annotations\AnnotationReader;
use Exception;
use SmartpingApi\Enum\ApiEndpoint;
use SmartpingApi\Enum\OrganizationType;
use SmartpingApi\Model\Organization\Organization;
use SmartpingApi\Model\Player\Player;
use SmartpingApi\Model\Player\RankedPlayer;
use SmartpingApi\Model\Player\SPIDPlayer;
use SmartpingApi\Model\SmartpingObject;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

abstract class SmartpingCore
{

    /** @var string Identifiant unique fourni par la FFTT. */
    protected static string $appId = '';

    /** @var string Mot de passe unique fourni par la FFTT. */
    protected static string $appKey = '';

    /** @var string Chaîne de caractères identifiant l'utilisateur. */
    protected static string $serial = '';

    /** @var string URL de base sur laquelle les endpoints se greffent. */
    private static string $baseUrl = 'https://apiv2.fftt.com/mobile/pxml';

    /**
     * @var array<array-key, array{
     *     id: int,
     *     name: string,
     *     code: string,
     *     type: string,
     *     parentId: string
     * }> Store de l'ensemble des organismes, nécessaire
     * puisque l'API ne propose aucun endpoint pour en
     * récupérer une facilement par son identifiant.
     */
    protected static array $organizations = [];


    /**
     * @param RankedPlayer|RankedPlayer[]|null $rankedResponse
     * @param SPIDPlayer|SPIDPlayer[]|null     $spidResponse
     *
     * @return array<Player>
     */
    protected static function mergeRankedAndSpidPlayerCollection(
        RankedPlayer|array|null $rankedResponse,
        SPIDPlayer|array|null $spidResponse
    ) : array {
        if (
            (is_null($rankedResponse) && is_null($spidResponse))
            || (empty($rankedResponse) && empty($spidResponse))
        ) {
            return [];
        }

        $rankedCollection = match (true) {
            is_array($rankedResponse) => $rankedResponse,
            is_object($rankedResponse) => [$rankedResponse],
            default => [],
        };

        $spidCollection = match (true) {
            is_array($spidResponse) => $spidResponse,
            is_object($spidResponse) => [$spidResponse],
            default => [],
        };

        /**
         * @param array                   $list
         * @param RankedPlayer|SPIDPlayer $player
         *
         * @return array
         */
        $indexByLicence = function (array $list, RankedPlayer|SPIDPlayer $player) : array {
            $list[$player->licence()] = $player;

            return $list;
        };

        /** @var RankedPlayer[] $rankedIndexed */
        $rankedIndexed = empty($rankedCollection) ? [] : array_reduce($rankedCollection, $indexByLicence, []);

        /** @var SPIDPlayer[] $spidIndexed */
        $spidIndexed = empty($spidCollection) ? [] : array_reduce($spidCollection, $indexByLicence, []);

        $rankedKeys = array_keys($rankedIndexed);
        $spidKeys = array_keys($spidIndexed);

        /** @var array<Player> $results */
        $results = [];

        foreach ($rankedKeys as $licence) {
            if (in_array($licence, $spidKeys)) {
                $results[] = new Player(
                    spidPlayer: $spidIndexed[$licence],
                    rankedPlayer: $rankedIndexed[$licence]
                );

                unset($spidIndexed[$licence]);
            } else {
                $results[] = new Player(
                    spidPlayer: null,
                    rankedPlayer: $rankedIndexed[$licence]
                );
            }

            unset($rankedIndexed[$licence]);
        }

        if (count($spidIndexed) > 0) {
            foreach ($spidIndexed as $player) {
                $results[] = new Player(
                    spidPlayer: $player,
                    rankedPlayer: null
                );
            }
        }

        return $results;
    }


    protected static function populateOrganizations() : void
    {
        if (! empty(self::$organizations)) {
            return;
        }

        $orgTypes = OrganizationType::cases();

        /**
         * @return Organization[]
         */
        $fetch = function (OrganizationType $orgType) : array {
            /** @var Organization|Organization[]|null $response */
            $response = self::fetch(
                endpoint: ApiEndpoint::XML_ORGANISME,
                requestParams: [
                    'type' => $orgType->value,
                ],
                normalizationModel: Organization::class,
                rootKey: 'organisme',
            );

            if (is_null($response)) {
                return [];
            }

            if (is_object($response)) {
                return [$response];
            }

            return $response;
        };

        foreach ($orgTypes as $type) {
            $orgs = $fetch($type);
            /**
             * @var array<array-key, array{
             *     id: int,
             *     name: string,
             *     code: string,
             *     type: string,
             *     parentId: string
             * }> $orgsNormalized
             */
            $orgsNormalized = array_map(fn($org) => $org->normalize(), $orgs);
            self::$organizations = array_merge_recursive(self::$organizations, $orgsNormalized);
        }
    }


    protected static function getOrganizationInStore(int $organizationId) : ?Organization
    {
        $orgFound = array_filter(self::$organizations, fn($org) => $org['id'] === $organizationId);
        $orgFound = array_values($orgFound);

        if (empty($orgFound)) {
            return null;
        }

        $org = $orgFound[0];

        return new Organization(
            id: $org['id'],
            name: $org['name'],
            code: $org['code'],
            parentId: $org['parentId']
        );
    }


    /**
     * @param SmartpingObject|SmartpingObject[]|null $response
     *
     * @return SmartpingObject[]
     */
    protected static function getResponseAsArray(SmartpingObject|array|null $response): array
    {
        return match(true) {
          is_null($response) => [],
          is_object($response) => [$response],
          default => $response,
        };
    }

    /**
     * Appelle un endpoint et le convertit en modèle.
     *
     * @return SmartpingObject|SmartpingObject[]|null
     */
    protected static function fetch(
        ApiEndpoint $endpoint,
        array $requestParams,
        string $normalizationModel,
        string $rootKey,
    ) : SmartpingObject|array|null {
        try {
            $response = self::makeRequest($endpoint, $requestParams);

            return self::deserializeObject($response, $normalizationModel, $rootKey);
        } catch (Exception) {
            //var_dump(sprintf('ERROR : %s', $e->getMessage()));

            return null;
        }
    }


    /**
     * Convertit une réponse XML en l'objet demandé.
     *
     * @return SmartpingObject|SmartpingObject[]
     * @throws Exception
     */
    private static function deserializeObject(
        string $content,
        string $model,
        string $rootKey
    ) : SmartpingObject|array {
        $classMetadataFactory = new ClassMetadataFactory(
            new AnnotationLoader(new AnnotationReader())
        );
        $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory);
        $serializer = new Serializer(
            [
                new PropertyNormalizer($classMetadataFactory, $metadataAwareNameConverter),
                new ArrayDenormalizer(),
            ],
            [
                'xml' => new XmlEncoder(),
            ]
        );

        preg_match_all("/<{$rootKey}>/", $content, $rootKeyMatches);
        if (empty($rootKeyMatches[0])) {
            throw new Exception("The root key doesn't exist in the response body");
        }

        $decodedXML = simplexml_load_string($content, "SimpleXMLElement", LIBXML_NOCDATA);

        $isList = preg_match("/<liste>/", $content);
        $isSingleResult = $decodedXML->count() === 1;

        $suffix = match (true) {
            !$isList => '',
            $isList && $isSingleResult => '[]',
            $isList && !$isSingleResult => '[][]',
        };

        /** @var SmartpingObject|SmartpingObject[] $object */
        $object = $serializer->deserialize($content, "{$model}{$suffix}", 'xml');

        if (is_array($object)) {
            return $object[$rootKey] ?? $object;
        }

        return $object;
    }


    /**
     * Appelle un endpoint de la Fédération.
     *
     * @throws Exception
     */
    private static function makeRequest(ApiEndpoint $endpoint, array $requestParams) : string
    {
        $ch = curl_init();

        /**
         * Crée les paramètres communs obligatoires.
         */
        $time = date('YmdHis');
        $baseParams = [
            'serie' => self::$serial,
            'id'    => self::$appId,
            'tm'    => $time,
            'tmc'   => hash_hmac('sha1', $time, hash('md5', self::$appKey)),
        ];

        /**
         * @var array<string, string> $params
         * Merge l'ensemble des paramètres pour la requête.
         */
        $params = array_merge($baseParams, $requestParams);

        /**
         * Transforme les paramètres en paramètres de requête.
         */
        $queryParams = '';
        foreach ($params as $paramKey => $paramValue) {
            $queryParams .= "&{$paramKey}=".urlencode($paramValue);
        }

        /**
         * Supprime le premier `&`.
         */
        $queryParamsEncoded = substr($queryParams, 1, null);

        /**
         * Exécute la requête.
         */
        curl_setopt_array($ch, [
            CURLOPT_URL            => self::$baseUrl.$endpoint->value.'?'.$queryParamsEncoded,
            CURLOPT_HEADER         => false,
            CURLOPT_RETURNTRANSFER => true,
        ]);

        $response = (string)curl_exec($ch);
        $httpCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_error($ch)) {
            throw new Exception(curl_error($ch));
        }

        curl_close($ch);

        if (200 !== $httpCode) {
            throw new Exception("Unexpected HTTP status code received. Expected : 200 / Received : {$httpCode}");
        }

        return mb_convert_encoding(mb_convert_encoding($response, 'UTF-8', 'ISO-8859-1'), 'ISO-8859-1', 'UTF-8');
    }
}
