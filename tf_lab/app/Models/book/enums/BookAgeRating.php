<?php

namespace App\Models\book\enums;

use App\Utils\EnumToArray;

enum BookAgeRating: string
{
    use EnumToArray;

    case Age0Plus = '0+';
    case Age3Plus = '3+';
    case Age5Plus = '5+';
    case Age7Plus = '7+';
    case Age9Plus = '9+';
    case Age10Plus = '10+';
    case Age12Plus = '12+';
    case Age14Plus = '14+';
    case Age16Plus = '16+';
    case Age18Plus = '18+';
    case AA = 'AA';
    case PG = 'PG';
    case GR = 'GR';
    case MT = 'MT';
    case ED = 'ED';
    case YA = 'YA';
    case AF = 'AF';
    case ANF = 'ANF';
    case PS = 'PS';
    case R = 'R';
}
