<?php

declare(strict_types=1);

namespace SmartpingApi\Enum;

enum ContestType: string
{
    case TEAM = 'E';
    case INDIVIDUAL = 'I';
    case MEN = 'H';
    case CHAMPIONSHIP = 'C';
}
