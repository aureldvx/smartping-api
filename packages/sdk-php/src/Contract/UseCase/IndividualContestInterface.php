<?php

declare(strict_types=1);

namespace SmartpingApi\Contract\UseCase;

use SmartpingApi\Model\Contest\FederalCriteriumRank;
use SmartpingApi\Model\Contest\IndividualContestGame;
use SmartpingApi\Model\Contest\IndividualContestGroup;
use SmartpingApi\Model\Contest\IndividualContestRank;

interface IndividualContestInterface
{
    /**
     * xml_result_indiv.php
     * ---------------------------------------------------------
     * Renvoie les différents tours d’une épreuve individuelle.
     *
     * @return IndividualContestGroup[] Ensemble des tours trouvés
     */
    public static function getIndividualContestGroup(int $contestId, int $divisionId): array;

    /**
     * xml_result_indiv.php
     * ---------------------------------------------------------
     * Renvoie les différentes parties d’un tour d'une épreuve individuelle.
     *
     * @return IndividualContestGame[] Ensemble des parties trouvées
     */
    public static function getIndividualContestGames(int $contestId, int $divisionId, int $groupId = null): array;

    /**
     * xml_result_indiv.php
     * ---------------------------------------------------------
     * Renvoie le classement d’un tour d'une épreuve individuelle.
     *
     * @return IndividualContestRank[] Ensemble des classements trouvés
     */
    public static function getIndividualContestRank(int $contestId, int $divisionId, int $groupId = null): array;

    /**
     * xml_res_cla.php
     * ---------------------------------------------------------
     * Renvoie le classement général d’une division du critérium fédéral.
     *
     * @return FederalCriteriumRank[] Ensemble des classements trouvés
     */
    public static function getFederalCriteriumRankForDivision(int $divisionId): array;
}
