<?php

namespace SmartpingApi\Service;

use SmartpingApi\Contract\UseCase\TeamContestInterface;
use SmartpingApi\Enum\ApiEndpoint;
use SmartpingApi\Model\Contest\Team\TeamMatch;
use SmartpingApi\Model\Contest\Team\TeamMatchDetails;
use SmartpingApi\Model\Contest\Team\TeamPool;
use SmartpingApi\Model\Contest\Team\TeamPoolRank;

class TeamContestAPI extends SmartpingCore implements TeamContestInterface
{
    /**
     * @inheritDoc
     */
    public static function getTeamChampionshipPoolsForDivision(int $divisionId) : array
    {
        /** @var TeamPool|TeamPool[]|null $response */
        $response = SmartpingCore::fetch(
            endpoint: ApiEndpoint::XML_RESULT_EQU,
            requestParams: [
                'action' => 'poule',
                'auto' => '1',
                'D1' => (string) $divisionId,
            ],
            normalizationModel: TeamPool::class,
            rootKey: 'poule'
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
    public static function getTeamChampionshipMatchesForPool(int $divisionId, int $poolId = null) : array
    {
        /** @var TeamMatch|TeamMatch[]|null $response */
        $response = SmartpingCore::fetch(
            endpoint: ApiEndpoint::XML_RESULT_EQU,
            requestParams: [
                'action' => '',
                'auto' => '1',
                'D1' => (string) $divisionId,
                'cx_poule' => $poolId ? (string) $poolId : '',
            ],
            normalizationModel: TeamMatch::class,
            rootKey: 'tour'
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
    public static function getTeamChampionshipPoolRanking(int $divisionId, int $poolId = null) : array
    {
        /** @var TeamPoolRank|TeamPoolRank[]|null $response */
        $response = SmartpingCore::fetch(
            endpoint: ApiEndpoint::XML_RESULT_EQU,
            requestParams: [
                'action' => 'classement',
                'auto' => '1',
                'D1' => (string) $divisionId,
                'cx_poule' => $poolId ? (string) $poolId : '',
            ],
            normalizationModel: TeamPoolRank::class,
            rootKey: 'classement'
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
    public static function getTeamChampionshipMatch(int $matchId, array $extraParams) : ?TeamMatchDetails
    {
        /** @var TeamMatchDetails|null $response */
        $response = SmartpingCore::fetch(
            endpoint: ApiEndpoint::XML_CHP_RENC,
            requestParams: [
                'renc_id' => (string) $matchId,
                'is_retour' => (string) intval($extraParams['is_retour']),
                'phase' => (string) $extraParams['phase'],
                'res_1' => (string) $extraParams['res_1'],
                'res_2' => (string) $extraParams['res_2'],
                'equip_1' => $extraParams['equip_1'],
                'equip_2' => $extraParams['equip_2'],
                'equip_id1' => (string) $extraParams['equip_id1'],
                'equip_id2' => (string) $extraParams['equip_id2'],
            ],
            normalizationModel: TeamMatchDetails::class,
            // TODO
            rootKey: 'NOT_DEFINED'
        );

        return $response;
    }
}
