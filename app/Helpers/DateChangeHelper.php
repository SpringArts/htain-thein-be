<?php

use Carbon\Carbon;

if (!function_exists('changeToDifferForHuman')) {
    function changeToDifferForHuman(Carbon $date): string
    {
        return $date->diffForHumans();
    }
}

if (!function_exists('formatDateTime')) {
    function formatDateTime(Carbon|string $date): string
    {
        $newDate = $date instanceof Carbon ? $date : new Carbon($date);
        return $newDate->format('Y-d-M h:i A');
    }
}

if (!function_exists('formatDate')) {
    function formatDate(Carbon|string $date): string
    {
        $newDate = $date instanceof Carbon ? $date : new Carbon($date);
        return $newDate->format('Y-d-M');
    }
}
