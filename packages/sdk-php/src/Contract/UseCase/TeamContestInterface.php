<?php

declare(strict_types=1);

namespace SmartpingApi\Contract\UseCase;

use SmartpingApi\Model\Contest\Team\TeamMatch;
use SmartpingApi\Model\Contest\Team\TeamMatchDetails;
use SmartpingApi\Model\Contest\Team\TeamPool;
use SmartpingApi\Model\Contest\Team\TeamPoolRank;

interface TeamContestInterface
{
    /**
     * xml_result_equ.php
     * ---------------------------------------------------------
     * Renvoie la liste des poules d'une division de championnat
     * par équipes.
     *
     * @return TeamPool[] Ensemble des poules trouvées
     */
    public static function getTeamChampionshipPoolsForDivision(int $divisionId): array;

    /**
     * xml_result_equ.php
     * ---------------------------------------------------------
     * Renvoie la liste des rencontres d'une poule de championnat
     * par équipes.
     *
     * @return TeamMatch[] Ensemble des rencontres trouvées
     */
    public static function getTeamChampionshipMatchesForPool(int $divisionId, int $poolId = null): array;

    /**
     * xml_result_equ.php
     * ---------------------------------------------------------
     * Renvoie le classement d'une poule de championnat par équipes.
     *
     * @return TeamPoolRank[] Ensemble des classements trouvés
     */
    public static function getTeamChampionshipPoolRanking(int $divisionId, int $poolId = null): array;

    /**
     * xml_chp_renc.php
     * ---------------------------------------------------------
     * Renvoie les informations détaillées d’une rencontre.
     *
     * @param array{
     *     is_retour: bool,
     *     phase: int,
     *     res_1: int,
     *     res_2: int,
     *     equip_1: string,
     *     equip_2: string,
     *     equip_id1: int,
     *     equip_id2: int
     * } $extraParams
     *
     * @return TeamMatchDetails|null Détails de la rencontre si trouvée
     */
    public static function getTeamChampionshipMatch(int $matchId, array $extraParams): ?TeamMatchDetails;
}
