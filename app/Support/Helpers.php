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