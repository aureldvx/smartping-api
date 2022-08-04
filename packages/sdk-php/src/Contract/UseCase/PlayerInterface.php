<?php

declare(strict_types=1);

namespace SmartpingApi\Contract\UseCase;


use SmartpingApi\Model\Player\Game;
use SmartpingApi\Model\Player\Player;
use SmartpingApi\Model\Player\PlayerDetails;
use SmartpingApi\Model\Player\PlayerRankHistory;

interface PlayerInterface
{
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
     * xml_licence_b.php
     * ---------------------------------------------------------
     * Cherche un joueur par son numéro de licence.
     *
     * @return PlayerDetails|null Joueur trouvé (si existant)
     */
    public static function getPlayer(string $licence): ?PlayerDetails;

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
