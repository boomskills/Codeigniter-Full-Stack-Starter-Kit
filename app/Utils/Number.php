<?php

namespace App\Utils;

use App\Models\CountryModel;

// class Number
class Number
{
    public static function roundValue(float $value, int $precision = 2): float
    {
        return round($value, $precision, PHP_ROUND_HALF_UP);
    }

    /**
     * Formats a given value based on the settings->info.
     *
     * @param float  $value    The number to be formatted
     * @param object $settings The settings object
     *
     * @return string The formatted value
     */
    public static function formatValue($value, $settings): string
    {
        $value = floatval($value);

        $thousand = $settings->info->thousand_separator;
        $decimal = $settings->info->decimal_separator;
        $precision = $settings->info->precision;

        return number_format($value, $precision, $decimal, $thousand);
    }

    /**
     * Formats a given value based on the default settings->info
     * BACK to a float.
     *
     * @param string $value The formatted number to be converted back to float
     *
     * @return float The formatted value
     */
    public static function parseFloat($value)
    {
        // convert "," to "."
        $s = str_replace(',', '.', $value);

        // remove everything except numbers and dot "."
        $s = preg_replace('/[^0-9\\.]/', '', $s);

        if ($s < 1) {
            return (float) $s;
        }

        // remove all seperators from first part and keep the end
        $s = str_replace('.', '', substr($s, 0, -3)) . substr($s, -3);

        // return float
        return (float) $s;
    }

    public static function parseStringFloat($value)
    {
        $value = preg_replace('/[^0-9-.]+/', '', $value);

        // check for comma as decimal separator
        if (preg_match('/,[\d]{1,2}$/', $value)) {
            $value = str_replace(',', '.', $value);
        }

        $value = preg_replace('/[^0-9\.\-]/', '', $value);

        return floatval($value);
    }
}
