<?php

declare(strict_types=1);

namespace SmartpingApi\Contract\UseCase;

use SmartpingApi\Enum\ContestType;
use SmartpingApi\Model\Contest\Contest;
use SmartpingApi\Model\Contest\Division;

interface ContestInterface
{
    /**
     * xml_epreuve.php
     * ---------------------------------------------------------
     * Renvoie une liste des épreuves pour un organisme.
     *
     * @return Contest[] Ensemble des épreuves trouvées
     */
    public static function findContests(int $organizationId, ContestType $contestType): array;

    /**
     * xml_division.php
     * ---------------------------------------------------------
     * Renvoie une liste des divisions pour une épreuve donnée.
     *
     * @return Division[] Ensemble des divisions trouvées
     */
    public static function findDivisionsForContest(
        int $organizationId,
        int $contestId,
        ContestType $contestType
    ): array;
}
