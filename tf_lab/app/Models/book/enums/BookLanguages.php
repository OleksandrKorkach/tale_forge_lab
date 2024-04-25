<?php

namespace App\Models\book\enums;

use App\Utils\EnumToArray;

enum BookLanguages: string
{
    use EnumToArray;

    case English = 'English';
    case Chinese = 'Chinese';
    case Hindi = 'Hindi';
    case Spanish = 'Spanish';
    case French = 'French';
    case Arabic = 'Arabic';
    case Bengali = 'Bengali';
    case Ukrainian = 'Ukrainian';
    case Portuguese = 'Portuguese';
    case Urdu = 'Urdu';
    case Indonesian = 'Indonesian';
    case German = 'German';
    case Japanese = 'Japanese';
    case Swahili = 'Swahili';
    case Marathi = 'Marathi';
    case Telugu = 'Telugu';
    case Turkish = 'Turkish';
    case Korean = 'Korean';
    case Vietnamese = 'Vietnamese';
    case Tamil = 'Tamil';
}
