<?php

declare(strict_types=1);

namespace SmartpingApi\Contract\UseCase;

use SmartpingApi\Model\Player\Game;
use SmartpingApi\Model\Player\Player;
use SmartpingApi\Model\Player\PlayerDetails;
use SmartpingApi\Model\Player\PlayerRankHistory;
use SmartpingApi\Model\Player\RankedGame;
use SmartpingApi\Model\Player\RankedPlayer;
use SmartpingApi\Model\Player\SPIDGame;
use SmartpingApi\Model\Player\SPIDPlayer;

interface PlayerInterface
{
    /**
     * xml_liste_joueur.php
     * ---------------------------------------------------------
     * Cherche un ou plusieurs joueur(s) par leur
     * nom (et prénom éventuellement) sur la base classement.
     *
     * @return RankedPlayer[] Ensemble des joueurs trouvés
     */
    public static function findPlayersByNameOnRankingBase(string $lastname, string $firstname = null): array;

    /**
     * xml_liste_joueur_o.php
     * ---------------------------------------------------------
     * Cherche un ou plusieurs joueur(s) par leur
     * nom (et prénom éventuellement) sur la base SPID.
     *
     * @param bool $valid Filtrer uniquement sur les licences
     *                    de la saison en cours
     *
     * @return SPIDPlayer[] Ensemble des joueurs trouvés
     */
    public static function findPlayersByNameOnSpidBase(string $lastname, string $firstname = null, bool $valid = false): array;

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
    public static function findPlayersByName(string $lastname, string $firstname = null, bool $valid = false): array;

    /**
     * xml_liste_joueur.php
     * ---------------------------------------------------------
     * Cherche un ou plusieurs joueur(s) par leur numéro de club
     * sur la base classement.
     *
     * @return RankedPlayer[] Ensemble des joueurs trouvés
     */
    public static function findPlayersByClubOnRankingBase(string $clubCode): array;

    /**
     * xml_liste_joueur_o.php
     * ---------------------------------------------------------
     * Cherche un ou plusieurs joueur(s) par leur numéro de club
     * sur la base SPID.
     *
     * @param bool $valid Filtrer uniquement sur les licences
     *                    de la saison en cours
     *
     * @return SPIDPlayer[] Ensemble des joueurs trouvés
     */
    public static function findPlayersByClubOnSpidBase(string $clubCode, bool $valid = false): array;

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
    public static function findPlayersByClub(string $clubCode, bool $valid = false): array;

    /**
     * xml_joueur.php
     * ---------------------------------------------------------
     * Cherche un joueur par son numéro de licence dans la
     * base classement.
     *
     * @return RankedPlayer|null Joueur (si trouvé)
     */
    public static function getPlayerOnRankingBase(string $licence): ?RankedPlayer;

    /**
     * xml_licence.php
     * ---------------------------------------------------------
     * Cherche un joueur par son numéro de licence dans la
     * base SPID.
     *
     * @return SPIDPlayer|null Joueur (si trouvé)
     */
    public static function getPlayerOnSpidBase(string $licence): ?SPIDPlayer;

    /**
     * xml_licence_b.php
     * ---------------------------------------------------------
     * Cherche un joueur par son numéro de licence.
     *
     * @return PlayerDetails|null Joueur trouvé (si existant)
     */
    public static function getPlayer(string $licence): ?PlayerDetails;

    /**
     * xml_partie_mysql.php
     * ---------------------------------------------------------
     * Renvoie la liste des parties de la base classement
     * d’un joueur.
     *
     * @return RankedGame[] Ensemble des parties trouvées
     */
    public static function getPlayerGameHistoryOnRankingBase(string $licence): array;

    /**
     * xml_partie.php
     * ---------------------------------------------------------
     * Renvoie la liste des parties de la base SPID
     * d’un joueur.
     *
     * @return SPIDGame[] Ensemble des parties trouvées
     */
    public static function getPlayerGameHistoryOnSpidBase(string $licence): array;

    /**
     * xml_partie.php
     * ---------------------------------------------------------
     * Renvoie une liste des parties d’un joueur.
     *
     * @return Game[] Ensemble des parties trouvées
     */
    public static function getPlayerGameHistory(string $licence): array;

    /**
     * xml_histo_classement.php
     * ---------------------------------------------------------
     * Renvoie une liste des parties d’un joueur.
     *
     * @return PlayerRankHistory[] Ensemble des parties trouvées
     */
    public static function getPlayerRankHistory(string $licence): array;
}
