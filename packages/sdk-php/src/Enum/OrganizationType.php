<?php

declare(strict_types=1);

namespace SmartpingApi\Enum;

enum OrganizationType: string
{
    case FEDERATION = 'F';
    case ZONE = 'Z';
    case LEAGUE = 'L';
    case DEPARTMENT = 'D';
}
