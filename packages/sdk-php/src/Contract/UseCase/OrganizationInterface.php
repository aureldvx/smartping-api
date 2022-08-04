<?php

declare(strict_types=1);

namespace SmartpingApi\Contract\UseCase;

use SmartpingApi\Enum\OrganizationType;
use SmartpingApi\Model\Organization\Organization;

interface OrganizationInterface
{
    /**
     * xml_organisme.php
     * ---------------------------------------------------------
     * Renvoie une liste des organismes.
     *
     * @return Organization[] Ensemble des organismes répondant au type
     */
    public static function findOrganizationsByType(OrganizationType $orgType): array;

    /**
     * xml_organisme.php
     * ---------------------------------------------------------
     * Cherche un organisme par son type et son identifiant.
     *
     * @return Organization|null Organisme (si trouvé)
     */
    public static function getOrganization(int $organizationId): ?Organization;

    /**
     * xml_organisme.php
     * ---------------------------------------------------------
     * Cherche les organismes dépendants de l'organisme donné.
     *
     * @return Organization[] Organismes enfants
     */
    public static function getOrganizationChildren(int $organizationId): array;
}
