<?php

namespace App\Utils;

use DateTime;

class DateUtil
{
    public static function getCurrentSeason(): string
    {
        $now = new DateTime();
        return self::getSeason($now);
    }

    public static function getSeason($date): string
    {
        $month = $date->format('n');

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
