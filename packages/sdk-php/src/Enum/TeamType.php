<?php

declare(strict_types=1);

namespace SmartpingApi\Enum;

enum TeamType: string
{
    case MEN = 'M';
    case WOMEN = 'F';
    case MIXED = 'A';
    case OTHERS = '';
}
