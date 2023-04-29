<?php

namespace App\Services;

class EventService
{
    public static function checkEventDuplication($eventDate, $startTime, $endTime)
    {
        return Event::query()->whereDate('start_date', $eventDate)
            ->whereTime('end_date', '>', $startTime)
            ->whereTime('start_date', '<', $endTime)
            ->exists();
    }

    public static function joinDateAndTime($date, $time)
    {
        $dateTime = $date . " " . $time;

        return Carbon::createFromFormat('Y-m-d H:i', $dateTime);
    }
}
