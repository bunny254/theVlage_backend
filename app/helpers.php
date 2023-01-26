<?php

use Carbon\Carbon;
use Illuminate\Support\Collection;

function parseDatetime($dateStr, $timeZone = 'Africa/Nairobi')
{
    return Carbon::create($dateStr, $timeZone)->timezone('UTC');
}

function parseDatetimeII($dateStr, $dateFormat = 'd/m/Y h:i a', $timeZone = 'Africa/Nairobi')
{
    return Carbon::createFromFormat($dateFormat, $dateStr, $timeZone)->timezone('UTC');
}

function mediumDate($dateStr, $dateFormat = 'jS M Y g:i A', $timeZone = 'Africa/Nairobi') {
    return $dateStr->timezone($timeZone)->format($dateFormat);
}

function timeDiff($dateStr) {
    return $dateStr->diffForHumans();
}

function prettyJSON(array $arr)
{
    return Collection::make($arr)->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

function appendCountryCode($phone, $code = '254') {
    return $code . Str::substr($phone, -9);
}

function removeCountryCode($phone, $prefix = '0') {
    return $prefix . Str::substr($phone, -9);
}
