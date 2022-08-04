<?php

declare(strict_types=1);

namespace SmartpingApi\Contract\UseCase;

use SmartpingApi\Model\Common\News;

interface CommonInterface
{
    /**
     * xml_initialisation.php
     * ---------------------------------------------------------
     * Vérifie et crée un nouvel utilisateur pour l'application.
     *
     * @return bool Accès autorisé ou non
     */
    public static function authenticate(): bool;

    /**
     * xml_new_actu.php
     * ---------------------------------------------------------
     * Renvoie le flux d’actualités de la FFTT.
     *
     * @return News[] Ensemble des actualités
     */
    public static function getFederationNewsFeed(): array;
}
