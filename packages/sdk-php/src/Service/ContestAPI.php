<?php

namespace SmartpingApi\Service;

use SmartpingApi\Contract\UseCase\ContestInterface;
use SmartpingApi\Enum\ApiEndpoint;
use SmartpingApi\Enum\ContestType;
use SmartpingApi\Model\Contest\Contest;
use SmartpingApi\Model\Contest\Division;

final class ContestAPI extends SmartpingCore implements ContestInterface
{
    /**
     * @inheritDoc
     */
    public static function findContests(int $organizationId, ContestType $contestType) : array
    {
        /** @var Contest|Contest[]|null $response */
        $response = SmartpingCore::fetch(
            endpoint: ApiEndpoint::XML_EPREUVE,
            requestParams: [
                'organisme' => (string) $organizationId,
                'type' => $contestType->value,
            ],
            normalizationModel: Contest::class,
            rootKey: 'epreuve'
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
    public static function findDivisionsForContest(int $organizationId, int $contestId, ContestType $contestType) : array
    {
        /** @var Division|Division[]|null $response */
        $response = SmartpingCore::fetch(
            endpoint: ApiEndpoint::XML_DIVISION,
            requestParams: [
                'organisme' => (string) $organizationId,
                'epreuve' => (string) $contestId,
                'type' => $contestType->value,
            ],
            normalizationModel: Division::class,
            rootKey: 'division'
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
