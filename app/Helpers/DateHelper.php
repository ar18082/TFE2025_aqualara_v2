<?php

namespace App\Helpers;

class DateHelper
{
    public static function insertSlash($string)
    {
        if (strlen($string) == 4) {
            return substr($string, 0, 2) . '/' . substr($string, 2);
        }
        return $string;
    }
} 