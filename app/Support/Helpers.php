<?php
if (!function_exists('calc_minutes')) {
    /**
     * Convert decimal number to minutes
     *
     * @param $decimal
     * @return bool|int
     */
    function convert_to_minutes($float)
    {
        if (floor($float) != $float) {
            list($whole, $decimal) = explode('.', $float);
        } else {
            $whole = $float;
            $decimal = 0;
        }

        $minutes = 0;
        if ($decimal < 1) {
            switch ($decimal) {
                case 25:
                    $minutes = 15;
                    break;
                case 5:
                    $minutes = 30;
                    break;
                case 75:
                    $minutes = 45;
                    break;
            }
        }

        return $minutes + ($whole * 60);

        return false;
    }
}

if (!function_exists('getDays')) {

    /**
     * Gets total days from overtime
     *
     * @param Float $hours
     * @return float
     */
    function getDays(Float $hours)
    {
        $minutes = convert_to_minutes($hours);

        return floor($minutes / (60 * 8));
    }
}

if (!function_exists('getRemainingMinutes')) {

    /**
     * This function gets the remaining minutes of a work day
     *
     * @param Float $hours
     * @return int
     */
    function getRemainingMinutes(Float $hours)
    {
        $minutes = convert_to_minutes($hours);

        return $minutes % (60 * 8);
    }
}