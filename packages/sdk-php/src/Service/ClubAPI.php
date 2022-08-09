<?php

namespace SmartpingApi\Service;

use SmartpingApi\Contract\UseCase\ClubInterface;
use SmartpingApi\Enum\ApiEndpoint;
use SmartpingApi\Enum\TeamType;
use SmartpingApi\Model\Club\Club;
use SmartpingApi\Model\Club\ClubDetail;
use SmartpingApi\Model\Club\ClubTeam;

final class ClubAPI extends SmartpingCore implements ClubInterface
{
    /**
     * @inheritDoc
     */
    public static function findClubsByDepartment(string $department) : array
    {
        /** @var Club|Club[]|null $response */
        $response = SmartpingCore::fetch(
            endpoint: ApiEndpoint::XML_CLUB_B,
            requestParams: [
                'dep' => $department,
            ],
            normalizationModel: Club::class,
            rootKey: 'club'
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
    public static function findClubsByPostalCode(string $postalCode) : array
    {
        /** @var Club|Club[]|null $response */
        $response = SmartpingCore::fetch(
            endpoint: ApiEndpoint::XML_CLUB_B,
            requestParams: [
                'code' => $postalCode,
            ],
            normalizationModel: Club::class,
            rootKey: 'club'
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
    public static function findClubsByCity(string $city) : array
    {
        /** @var Club|Club[]|null $response */
        $response = SmartpingCore::fetch(
            endpoint: ApiEndpoint::XML_CLUB_B,
            requestParams: [
                'ville' => $city,
            ],
            normalizationModel: Club::class,
            rootKey: 'club'
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
    public static function findClubsByName(string $name) : array
    {
        /** @var Club|Club[]|null $response */
        $response = SmartpingCore::fetch(
            endpoint: ApiEndpoint::XML_CLUB_B,
            requestParams: [
                'ville' => $name,
            ],
            normalizationModel: Club::class,
            rootKey: 'club'
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
    public static function getClub(string $code) : ?ClubDetail
    {
        /** @var ClubDetail|null $response */
        $response = SmartpingCore::fetch(
            endpoint: ApiEndpoint::XML_CLUB_DETAIL,
            requestParams: [
                'club' => $code,
            ],
            normalizationModel: ClubDetail::class,
            rootKey: 'club'
        );

        return $response;
    }


    /**
     * @inheritDoc
     */
    public static function getTeamsForClub(string $clubCode, TeamType $teamType) : array
    {
        /** @var ClubTeam|ClubTeam[]|null $response */
        $response = SmartpingCore::fetch(
            endpoint: ApiEndpoint::XML_EQUIPE,
            requestParams: [
                'numclu' => $clubCode,
                'type' => $teamType->value,
            ],
            normalizationModel: ClubTeam::class,
            rootKey: 'equipe'
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
