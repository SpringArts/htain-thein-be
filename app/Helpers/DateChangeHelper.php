<?php

use App\Exceptions\CustomErrorException;
use Carbon\Carbon;
use Illuminate\Http\Response;

if (! function_exists('changeToDifferForHuman')) {
    function changeToDifferForHuman(mixed $date): string
    {
        if ($date instanceof Carbon) {
            $newDate = $date;
        } elseif (is_string($date) || $date instanceof DateTimeInterface) {
            $newDate = new Carbon($date);
        } else {
            throw new CustomErrorException('The $date parameter must be a string, a DateTimeInterface instance, or null.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $newDate->diffForHumans();
    }
}

if (! function_exists('formatDateTime')) {
    function formatDateTime(Carbon|string $date): string
    {
        $newDate = $date instanceof Carbon ? $date : new Carbon($date);

        return $newDate->format('Y-d-M h:i A');
    }
}

if (! function_exists('formatDate')) {
    function formatDate(Carbon|string $date): string
    {
        $newDate = $date instanceof Carbon ? $date : new Carbon($date);

        return $newDate->format('Y-d-M');
    }
}
