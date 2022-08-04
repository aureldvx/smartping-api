<?php

declare(strict_types=1);

namespace SmartpingApi\Contract\UseCase;

use SmartpingApi\Enum\TeamType;
use SmartpingApi\Model\Club\Club;
use SmartpingApi\Model\Club\ClubDetail;
use SmartpingApi\Model\Club\ClubTeam;

interface ClubInterface
{
    /**
     * xml_club_dep2.php
     * ---------------------------------------------------------
     * Renvoie une liste de clubs pour un département.
     *
     * @return Club[] Ensemble des clubs du département
     */
    public static function findClubsByDepartment(string $department): array;

    /**
     * xml_club_b.php
     * ---------------------------------------------------------
     * Renvoie une liste de clubs par rapport à un code postal.
     *
     * @return Club[] Ensemble des clubs trouvés
     */
    public static function findClubsByPostalCode(string $postalCode): array;

    /**
     * xml_club_b.php
     * ---------------------------------------------------------
     * Renvoie une liste de clubs par rapport à une ville.
     *
     * @return Club[] Ensemble des clubs trouvés
     */
    public static function findClubsByCity(string $city): array;

    /**
     * xml_club_b.php
     * ---------------------------------------------------------
     * Renvoie une liste de clubs par rapport à un nom.
     *
     * @return Club[] Ensemble des clubs trouvés
     */
    public static function findClubsByName(string $name): array;

    /**
     * xml_club_detail.php
     * ---------------------------------------------------------
     * Renvoie le détail pour un club.
     *
     * @return ClubDetail|null Club si trouvé
     */
    public static function getClub(string $code): ?ClubDetail;

    /**
     * xml_equipe.php
     * ---------------------------------------------------------
     * Renvoie une liste des équipes d’un club.
     *
     * @return ClubTeam[] Ensemble des équipes trouvées
     */
    public static function getTeamsForClub(string $clubCode, TeamType $teamType): array;
}
