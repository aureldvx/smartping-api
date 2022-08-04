<?php

declare(strict_types=1);

namespace SmartpingApi\Enum;

enum Certificate: string
{
    case OK = 'C';
    case NO_TRAINING = 'N';
    case QUADRUPLE = 'Q';
    case UNDEFINED = '';
}
