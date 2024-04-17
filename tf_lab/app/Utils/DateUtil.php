<?php

namespace App\Utils;

class DateUtil
{
    public static function getCurrentSeason(): string
    {
        $month = date('n');

        if ($month >= 3 && $month <= 5) {
            return 'Spring';
        } elseif ($month >= 6 && $month <= 8) {
            return 'Summer';
        } elseif ($month >= 9 && $month <= 11) {
            return 'Autumn';
        } else {
            return 'Winter';
        }
    }

}
