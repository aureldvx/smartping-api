<?php

declare(strict_types=1);

namespace SmartpingApi\Contract;

use SmartpingApi\Enum\ContestType;
use SmartpingApi\Enum\OrganizationType;
use SmartpingApi\Enum\TeamType;
use SmartpingApi\Model\Club\Club;
use SmartpingApi\Model\Club\ClubDetail;
use SmartpingApi\Model\Club\ClubTeam;
use SmartpingApi\Model\Common\News;
use SmartpingApi\Model\Contest\Contest;
use SmartpingApi\Model\Contest\Division;
use SmartpingApi\Model\Contest\Individual\FederalCriteriumRank;
use SmartpingApi\Model\Contest\Individual\IndividualContestGame;
use SmartpingApi\Model\Contest\Individual\IndividualContestGroup;
use SmartpingApi\Model\Contest\Individual\IndividualContestRank;
use SmartpingApi\Model\Contest\Team\TeamMatch;
use SmartpingApi\Model\Contest\Team\TeamMatchDetails;
use SmartpingApi\Model\Contest\Team\TeamPool;
use SmartpingApi\Model\Contest\Team\TeamPoolRank;
use SmartpingApi\Model\Organization\Organization;
use SmartpingApi\Model\Player\Game;
use SmartpingApi\Model\Player\Player;
use SmartpingApi\Model\Player\PlayerDetails;
use SmartpingApi\Model\Player\PlayerRankHistory;
use SmartpingApi\Model\Player\RankedGame;
use SmartpingApi\Model\Player\SPIDGame;

/**
 * Contrat d'implémentation pour utiliser l'API fournie
 * par la Fédération Française de Tennis de Table.
 *
 * Chaque endpoint doit fournir en plus de ses paramètres spécifiques
 * les paramètres suivants :
 * - serie : chaîne aléatoire de 15 caractères (/[a-zA-Z0-9]/) unique pour chaque utilisateur
 * - tm : timestamp actuel
 * - tmc : timestamp actuel crypté
 * - id : identifiant de l'application fournie par la Fédération
 */
interface SmartpingInterface
{
    public function __construct(string $appId, string $appKey);

    /**
     * xml_initialisation.php
     * ---------------------------------------------------------
     * Vérifie et crée un nouvel utilisateur pour l'application.
     *
     * @return bool Accès autorisé ou non
     */
    public function authenticate(): bool;

    /**
     * xml_new_actu.php
     * ---------------------------------------------------------
     * Renvoie le flux d’actualités de la FFTT.
     *
     * @return News[] Ensemble des actualités
     */
    public function getFederationNewsFeed(): array;

    /**
     * xml_organisme.php
     * ---------------------------------------------------------
     * Renvoie une liste des organismes.
     *
     * @return Organization[] Ensemble des organismes répondant au type
     */
    public function findOrganizationsByType(OrganizationType $orgType): array;

    /**
     * xml_organisme.php
     * ---------------------------------------------------------
     * Cherche un organisme par son type et son identifiant.
     *
     * @return Organization|null Organisme (si trouvé)
     */
    public function getOrganization(int $organizationId): ?Organization;

    /**
     * xml_organisme.php
     * ---------------------------------------------------------
     * Cherche les organismes dépendants de l'organisme donné.
     *
     * @return Organization[] Organismes enfants
     */
    public function getOrganizationChildren(int $organizationId): array;

    /**
     * xml_club_dep2.php
     * ---------------------------------------------------------
     * Renvoie une liste de clubs pour un département.
     *
     * @return Club[] Ensemble des clubs du département
     */
    public function findClubsByDepartment(string $department): array;

    /**
     * xml_club_b.php
     * ---------------------------------------------------------
     * Renvoie une liste de clubs par rapport à un code postal.
     *
     * @return Club[] Ensemble des clubs trouvés
     */
    public function findClubsByPostalCode(string $postalCode): array;

    /**
     * xml_club_b.php
     * ---------------------------------------------------------
     * Renvoie une liste de clubs par rapport à une ville.
     *
     * @return Club[] Ensemble des clubs trouvés
     */
    public function findClubsByCity(string $city): array;

    /**
     * xml_club_b.php
     * ---------------------------------------------------------
     * Renvoie une liste de clubs par rapport à un nom.
     *
     * @return Club[] Ensemble des clubs trouvés
     */
    public function findClubsByName(string $name): array;

    /**
     * xml_club_detail.php
     * ---------------------------------------------------------
     * Renvoie le détail pour un club.
     *
     * @return ClubDetail|null Club si trouvé
     */
    public function getClub(string $code): ?ClubDetail;

    /**
     * xml_equipe.php
     * ---------------------------------------------------------
     * Renvoie une liste des équipes d’un club.
     *
     * @return ClubTeam[] Ensemble des équipes trouvées
     */
    public function getTeamsForClub(string $clubCode, TeamType $teamType): array;

    /**
     * xml_liste_joueur_o.php
     * ---------------------------------------------------------
     * Cherche un ou plusieurs joueur(s) par leur
     * nom (et prénom éventuellement).
     *
     * @param bool $valid Filtrer uniquement sur les licences
     *                    de la saison en cours
     *
     * @return Player[] Ensemble des joueurs trouvés
     */
    public function findPlayersByName(string $lastname, string $firstname = null, bool $valid = false): array;

    /**
     * xml_liste_joueur_o.php
     * ---------------------------------------------------------
     * Cherche un ou plusieurs joueur(s) par leur numéro de club.
     *
     * @param bool $valid Filtrer uniquement sur les licences
     *                    de la saison en cours
     *
     * @return Player[] Ensemble des joueurs trouvés
     */
    public function findPlayersByClub(string $clubCode, bool $valid = false): array;

    /**
     * xml_licence_b.php
     * ---------------------------------------------------------
     * Cherche un joueur par son numéro de licence.
     *
     * @return PlayerDetails|null Joueur trouvé (si existant)
     */
    public function getPlayer(string $licence): ?PlayerDetails;

    /**
     * xml_partie_mysql.php
     * ---------------------------------------------------------
     * Renvoie la liste des parties de la base classement
     * d’un joueur.
     *
     * @return RankedGame[] Ensemble des parties trouvées
     */
    public function getPlayerGameHistoryOnRankingBase(string $licence): array;

    /**
     * xml_partie.php
     * ---------------------------------------------------------
     * Renvoie la liste des parties de la base SPID
     * d’un joueur.
     *
     * @return SPIDGame[] Ensemble des parties trouvées
     */
    public function getPlayerGameHistoryOnSpidBase(string $licence): array;

    /**
     * xml_partie.php
     * ---------------------------------------------------------
     * Renvoie une liste des parties d’un joueur.
     *
     * @return Game[] Ensemble des parties trouvées
     */
    public function getPlayerGameHistory(string $licence): array;

    /**
     * xml_histo_classement.php
     * ---------------------------------------------------------
     * Renvoie une liste des parties d’un joueur.
     *
     * @return PlayerRankHistory[] Ensemble des parties trouvées
     */
    public function getPlayerRankHistory(string $licence): array;

    /**
     * xml_epreuve.php
     * ---------------------------------------------------------
     * Renvoie une liste des épreuves pour un organisme.
     *
     * @return Contest[] Ensemble des épreuves trouvées
     */
    public function findContests(int $organizationId, ContestType $contestType): array;

    /**
     * xml_division.php
     * ---------------------------------------------------------
     * Renvoie une liste des divisions pour une épreuve donnée.
     *
     * @return Division[] Ensemble des divisions trouvées
     */
    public function findDivisionsForContest(
        int $organizationId,
        int $contestId,
        ContestType $contestType
    ): array;

    /**
     * xml_result_equ.php
     * ---------------------------------------------------------
     * Renvoie la liste des poules d'une division de championnat
     * par équipes.
     *
     * @return TeamPool[] Ensemble des poules trouvées
     */
    public function getTeamChampionshipPoolsForDivision(int $divisionId): array;

    /**
     * xml_result_equ.php
     * ---------------------------------------------------------
     * Renvoie la liste des rencontres d'une poule de championnat
     * par équipes.
     *
     * @return TeamMatch[] Ensemble des rencontres trouvées
     */
    public function getTeamChampionshipMatchesForPool(int $divisionId, int $poolId = null): array;

    /**
     * xml_result_equ.php
     * ---------------------------------------------------------
     * Renvoie le classement d'une poule de championnat par équipes.
     *
     * @return TeamPoolRank[] Ensemble des classements trouvés
     */
    public function getTeamChampionshipPoolRanking(int $divisionId, int $poolId = null): array;

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
    public function getTeamChampionshipMatch(int $matchId, array $extraParams): ?TeamMatchDetails;

    /**
     * xml_result_indiv.php
     * ---------------------------------------------------------
     * Renvoie les différents tours d’une épreuve individuelle.
     *
     * @return IndividualContestGroup[] Ensemble des tours trouvés
     */
    public function getIndividualContestGroup(int $contestId, int $divisionId): array;

    /**
     * xml_result_indiv.php
     * ---------------------------------------------------------
     * Renvoie les différentes parties d’un tour d'une épreuve individuelle.
     *
     * @return IndividualContestGame[] Ensemble des parties trouvées
     */
    public function getIndividualContestGames(int $contestId, int $divisionId, int $groupId = null): array;

    /**
     * xml_result_indiv.php
     * ---------------------------------------------------------
     * Renvoie le classement d’un tour d'une épreuve individuelle.
     *
     * @return IndividualContestRank[] Ensemble des classements trouvés
     */
    public function getIndividualContestRank(int $contestId, int $divisionId, int $groupId = null): array;

    /**
     * xml_res_cla.php
     * ---------------------------------------------------------
     * Renvoie le classement général d’une division du critérium fédéral.
     *
     * @return FederalCriteriumRank[] Ensemble des classements trouvés
     */
    public function getFederalCriteriumRankForDivision(int $divisionId): array;
}
