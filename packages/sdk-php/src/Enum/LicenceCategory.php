<?php

namespace SmartpingApi\Enum;

enum LicenceCategory: string
{
    case POUSSIN = 'P';
    case BENJAMIN_1 = 'B1';
    case BENJAMIN_2 = 'B2';
    case MINIME_1 = 'M1';
    case MINIME_2 = 'M2';
    case CADET_1 = 'C1';
    case CADET_2 = 'C2';
    case JUNIOR_1 = 'J1';
    case JUNIOR_2 = 'J2';
    case JUNIOR_3 = 'J3';
    case SENIOR = 'S';
    case VETERAN_1 = 'V1';
    case VETERAN_2 = 'V2';
    case VETERAN_3 = 'V3';
    case VETERAN_4 = 'V4';
    case VETERAN_5 = 'V5';
    case UNDEFINED = '';
}
