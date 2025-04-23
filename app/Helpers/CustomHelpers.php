<?php

if (!function_exists('numberToAlpha')) {
    function numberToAlpha($number)
    {
        $alphas = range('A', 'Z');
        return $alphas[$number % 26];
    }
}
