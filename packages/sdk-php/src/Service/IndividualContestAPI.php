<?php

namespace SmartpingApi\Service;

use SmartpingApi\Contract\UseCase\IndividualContestInterface;

class IndividualContestAPI extends SmartpingCore implements IndividualContestInterface
{
    /**
     * @inheritDoc
     */
    public static function getIndividualContestGroup(int $contestId, int $divisionId) : array
    {
        // TODO: Implement getIndividualContestGroup() method.
        return [];
    }


    /**
     * @inheritDoc
     */
    public static function getIndividualContestGames(int $contestId, int $divisionId, int $groupId = null) : array
    {
        // TODO: Implement getIndividualContestGames() method.
        return [];
    }


    /**
     * @inheritDoc
     */
    public static function getIndividualContestRank(int $contestId, int $divisionId, int $groupId = null) : array
    {
        // TODO: Implement getIndividualContestRank() method.
        return [];
    }


    /**
     * @inheritDoc
     */
    public static function getFederalCriteriumRankForDivision(int $divisionId) : array
    {
        // TODO: Implement getFederalCriteriumRankForDivision() method.
        return [];
    }
}
