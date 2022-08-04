<?php

namespace SmartpingApi\Service;

use SmartpingApi\Contract\UseCase\PlayerInterface;
use SmartpingApi\Enum\ApiEndpoint;
use SmartpingApi\Model\Player\PlayerDetails;
use SmartpingApi\Model\Player\PlayerRankHistory;
use SmartpingApi\Model\Player\RankedPlayer;
use SmartpingApi\Model\Player\SPIDPlayer;

class PlayerAPI extends SmartpingCore implements PlayerInterface
{
    /**
     * @inheritDoc
     */
    public static function findPlayersByNameOnRankingBase(string $lastname, string $firstname = null): array
    {
        $params = [];
        $params['nom'] = $lastname;

        if ($firstname) {
            $params['prenom'] = $firstname;
        }

        /** @var RankedPlayer|RankedPlayer[]|null $response */
        $response = SmartpingCore::fetch(
            endpoint: ApiEndpoint::XML_LISTE_JOUEUR,
            requestParams: $params,
            normalizationModel: RankedPlayer::class,
            rootKey: 'joueur'
        );

        if (is_null($response)) {
            return [];
        }

        if (is_object($response)) {
            return [$response];
        }

        return $response;
    }

    /**
     * @inheritDoc
     */
    public static function findPlayersByNameOnSpidBase(string $lastname, string $firstname = null, bool $valid = false): array
    {
        $params = [];
        $params['nom'] = $lastname;

        if ($firstname) {
            $params['prenom'] = $firstname;
        }

        /** @var SPIDPlayer|SPIDPlayer[]|null $response */
        $response = SmartpingCore::fetch(
            endpoint: ApiEndpoint::XML_LISTE_JOUEUR_O,
            requestParams: array_merge($params, ['valid' => $valid ? '1' : '0']),
            normalizationModel: SPIDPlayer::class,
            rootKey: 'joueur'
        );

        if (is_null($response)) {
            return [];
        }

        if (is_object($response)) {
            return [$response];
        }

        return $response;
    }

    /**
     * @inheritDoc
     */
    public static function findPlayersByName(string $lastname, string $firstname = null, bool $valid = false) : array
    {
        $rankedResponse = self::findPlayersByNameOnRankingBase($lastname, $firstname);
        $spidResponse = self::findPlayersByNameOnSpidBase($lastname, $firstname, $valid);

        return SmartpingCore::mergeRankedAndSpidPlayerCollection($rankedResponse, $spidResponse);
    }

    /**
     * @inheritdoc
     */
    public static function findPlayersByClubOnRankingBase(string $clubCode): array
    {
        /** @var RankedPlayer|RankedPlayer[]|null $response */
        $response = SmartpingCore::fetch(
            endpoint: ApiEndpoint::XML_LISTE_JOUEUR,
            requestParams: ['club' => $clubCode],
            normalizationModel: RankedPlayer::class,
            rootKey: 'joueur'
        );

        if (is_null($response)) {
            return [];
        }

        if (is_object($response)) {
            return [$response];
        }

        return $response;
    }

    /**
     * @inheritdoc
     */
    public static function findPlayersByClubOnSpidBase(string $clubCode, bool $valid = false): array
    {
        /** @var SPIDPlayer|SPIDPlayer[]|null $response */
        $response = SmartpingCore::fetch(
            endpoint: ApiEndpoint::XML_LISTE_JOUEUR_O,
            requestParams: array_merge([
                'club' => $clubCode,
                'valid' => $valid ? '1' : '0'
            ]),
            normalizationModel: SPIDPlayer::class,
            rootKey: 'joueur'
        );

        if (is_null($response)) {
            return [];
        }

        if (is_object($response)) {
            return [$response];
        }

        return $response;
    }

    /**
     * @inheritDoc
     */
    public static function findPlayersByClub(string $clubCode, bool $valid = false): array
    {
        $rankedResponse = self::findPlayersByClubOnRankingBase($clubCode);
        $spidResponse = self::findPlayersByClubOnSpidBase($clubCode, $valid);

        return SmartpingCore::mergeRankedAndSpidPlayerCollection($rankedResponse, $spidResponse);
    }

    /**
     * @inheritDoc
     */
    public static function getPlayerOnRankingBase(string $licence): ?RankedPlayer
    {
        /** @var RankedPlayer|null $response */
        $response = SmartpingCore::fetch(
            endpoint: ApiEndpoint::XML_JOUEUR,
            requestParams: ['licence' => $licence],
            normalizationModel: RankedPlayer::class,
            rootKey: 'joueur'
        );

        return $response;
    }

    /**
     * @inheritDoc
     */
    public static function getPlayerOnSpidBase(string $licence): ?SPIDPlayer
    {
        /** @var SPIDPlayer|null $response */
        $response = SmartpingCore::fetch(
            endpoint: ApiEndpoint::XML_LICENCE,
            requestParams: ['licence' => $licence],
            normalizationModel: SPIDPlayer::class,
            rootKey: 'licence'
        );

        return $response;
    }

    /**
     * @inheritDoc
     */
    public static function getPlayer(string $licence): ?PlayerDetails
    {
        /** @var PlayerDetails|null $response */
        $response = SmartpingCore::fetch(
            endpoint: ApiEndpoint::XML_LICENCE_B,
            requestParams: ['licence' => $licence],
            normalizationModel: PlayerDetails::class,
            rootKey: 'licence'
        );

        return $response;
    }

    /**
     * @inheritDoc
     */
    public static function getPlayerGameHistory(string $licence): array
    {
        // TODO: Implement getPlayerGameHistory() method.
        return [];
    }

    /**
     * @inheritDoc
     */
    public static function getPlayerRankHistory(string $licence): array
    {
        /** @var PlayerRankHistory|PlayerRankHistory[]|null $response */
        $response = SmartpingCore::fetch(
            endpoint: ApiEndpoint::XML_HISTO_CLASSEMENT,
            requestParams: [
                'numlic' => $licence,
            ],
            normalizationModel: PlayerRankHistory::class,
            rootKey: 'histo'
        );

        if (is_null($response)) {
            return [];
        }

        if (is_object($response)) {
            return [$response];
        }

        return $response;
    }
}
