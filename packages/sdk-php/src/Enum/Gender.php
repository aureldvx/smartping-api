<?php

declare(strict_types=1);

namespace SmartpingApi\Enum;

enum Gender: string
{
    case MAN = 'M';
    case WOMAN = 'F';
    case UNDEFINED = '';
}
