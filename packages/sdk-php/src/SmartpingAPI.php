<?php

declare(strict_types=1);

namespace SmartpingApi;

use Exception;
use SmartpingApi\Enum\ContestType;
use SmartpingApi\Enum\OrganizationType;
use SmartpingApi\Enum\TeamType;
use SmartpingApi\Contract\SmartpingInterface;
use SmartpingApi\Model\Club\ClubDetail;
use SmartpingApi\Model\Contest\Team\TeamMatchDetails;
use SmartpingApi\Model\Organization\Organization;
use SmartpingApi\Model\Player\PlayerDetails;
use SmartpingApi\Model\Player\RankedGame;
use SmartpingApi\Service\ClubAPI;
use SmartpingApi\Service\CommonAPI;
use SmartpingApi\Service\ContestAPI;
use SmartpingApi\Service\IndividualContestAPI;
use SmartpingApi\Service\OrganizationAPI;
use SmartpingApi\Service\PlayerAPI;
use SmartpingApi\Service\SmartpingCore;
use SmartpingApi\Service\TeamContestAPI;

class SmartpingAPI extends SmartpingCore implements SmartpingInterface
{
    public function __construct(string $appId, string $appKey)
    {
        SmartpingCore::$appId = $appId;
        SmartpingCore::$appKey = $appKey;
        try {
            SmartpingCore::$serial = substr(bin2hex(random_bytes(10)), 0, 15);
        } catch (Exception) {
            SmartpingCore::$serial = 'a1b2c3d4e5f6g7h';
        }
    }

    /**
     * @inheritDoc
     */
    public function authenticate() : bool
    {
        return CommonAPI::authenticate();
    }


    /**
     * @inheritDoc
     */
    public function getFederationNewsFeed() : array
    {
        return CommonAPI::getFederationNewsFeed();
    }


    /**
     * @inheritDoc
     */
    public function findOrganizationsByType(OrganizationType $orgType) : array
    {
        return OrganizationAPI::findOrganizationsByType($orgType);
    }


    /**
     * @inheritDoc
     */
    public function getOrganization(int $organizationId) : ?Organization
    {
        return OrganizationAPI::getOrganization($organizationId);
    }


    /**
     * @inheritDoc
     */
    public function getOrganizationChildren(int $organizationId) : array
    {
        return OrganizationAPI::getOrganizationChildren($organizationId);
    }


    /**
     * @inheritDoc
     */
    public function findClubsByDepartment(string $department) : array
    {
        return ClubAPI::findClubsByDepartment($department);
    }


    /**
     * @inheritDoc
     */
    public function findClubsByPostalCode(string $postalCode) : array
    {
        return ClubAPI::findClubsByPostalCode($postalCode);
    }


    /**
     * @inheritDoc
     */
    public function findClubsByCity(string $city) : array
    {
        return ClubAPI::findClubsByCity($city);
    }


    /**
     * @inheritDoc
     */
    public function findClubsByName(string $name) : array
    {
        return ClubAPI::findClubsByName($name);
    }


    /**
     * @inheritDoc
     */
    public function getClub(string $code) : ?ClubDetail
    {
        return ClubAPI::getClub($code);
    }


    /**
     * @inheritDoc
     */
    public function getTeamsForClub(string $clubCode, TeamType $teamType) : array
    {
        return ClubAPI::getTeamsForClub($clubCode, $teamType);
    }


    /**
     * @inheritDoc
     */
    public function findPlayersByName(string $lastname, string $firstname = null, bool $valid = false) : array
    {
        return PlayerAPI::findPlayersByName($lastname, $firstname, $valid);
    }


    /**
     * @inheritDoc
     */
    public function findPlayersByClub(string $clubCode, bool $valid = false) : array
    {
        return PlayerAPI::findPlayersByClub($clubCode, $valid);
    }


    /**
     * @inheritDoc
     */
    public function getPlayer(string $licence) : ?PlayerDetails
    {
        return PlayerAPI::getPlayer($licence);
    }


    /**
     * @inheritdoc
     */
    public function getPlayerGameHistoryOnRankingBase(string $licence): array
    {
        return PlayerAPI::getPlayerGameHistoryOnRankingBase($licence);
    }


    /**
     * @inheritdoc
     */
    public function getPlayerGameHistoryOnSpidBase(string $licence): array
    {
        return PlayerAPI::getPlayerGameHistoryOnSpidBase($licence);
    }


    /**
     * @inheritDoc
     */
    public function getPlayerGameHistory(string $licence) : array
    {
        return PlayerAPI::getPlayerGameHistory($licence);
    }


    /**
     * @inheritDoc
     */
    public function getPlayerRankHistory(string $licence) : array
    {
        return PlayerAPI::getPlayerRankHistory($licence);
    }


    /**
     * @inheritDoc
     */
    public function findContests(int $organizationId, ContestType $contestType) : array
    {
        return ContestAPI::findContests($organizationId, $contestType);
    }


    /**
     * @inheritDoc
     */
    public function findDivisionsForContest(int $organizationId, int $contestId, ContestType $contestType) : array
    {
        return ContestAPI::findDivisionsForContest($organizationId, $contestId, $contestType);
    }


    /**
     * @inheritDoc
     */
    public function getTeamChampionshipPoolsForDivision(int $divisionId) : array
    {
        return TeamContestAPI::getTeamChampionshipPoolsForDivision($divisionId);
    }


    /**
     * @inheritDoc
     */
    public function getTeamChampionshipMatchesForPool(int $divisionId, int $poolId = null) : array
    {
        return TeamContestAPI::getTeamChampionshipMatchesForPool($divisionId, $poolId);
    }


    /**
     * @inheritDoc
     */
    public function getTeamChampionshipPoolRanking(int $divisionId, int $poolId = null) : array
    {
        return TeamContestAPI::getTeamChampionshipPoolRanking($divisionId, $poolId);
    }


    /**
     * @inheritDoc
     */
    public function getTeamChampionshipMatch(int $matchId, array $extraParams) : ?TeamMatchDetails
    {
        return TeamContestAPI::getTeamChampionshipMatch($matchId, $extraParams);
    }


    /**
     * @inheritDoc
     */
    public function getIndividualContestGroup(int $contestId, int $divisionId) : array
    {
        return IndividualContestAPI::getIndividualContestGroup($contestId, $divisionId);
    }


    /**
     * @inheritDoc
     */
    public function getIndividualContestGames(int $contestId, int $divisionId, int $groupId = null) : array
    {
        return IndividualContestAPI::getIndividualContestGames($contestId, $divisionId, $groupId);
    }


    /**
     * @inheritDoc
     */
    public function getIndividualContestRank(int $contestId, int $divisionId, int $groupId = null) : array
    {
        return IndividualContestAPI::getIndividualContestRank($contestId, $divisionId, $groupId);
    }


    /**
     * @inheritDoc
     */
    public function getFederalCriteriumRankForDivision(int $divisionId) : array
    {
        return IndividualContestAPI::getFederalCriteriumRankForDivision($divisionId);
    }
}
