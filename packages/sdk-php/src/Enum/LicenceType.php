<?php

declare(strict_types=1);

namespace SmartpingApi\Enum;

enum LicenceType: string
{
    case COMPETITION = 'T';
    case TRAINING = 'P';
    case EVENT = 'E';
    case UNDEFINED = '';
}
