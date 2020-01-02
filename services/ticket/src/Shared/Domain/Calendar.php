<?php
declare(strict_types=1);

namespace Ticket\Shared\Domain;

class Calendar
{
    protected static ?CalendarProvider $calendarProvider = null;

    public static function now(): \DateTimeInterface
    {
        return static::getCalendarProvider()->now();
    }

    private static function getCalendarProvider(): CalendarProvider
    {
        if (\is_null(static::$calendarProvider)) {
            static::$calendarProvider = new RealTimeProvider();
        }

        return static::$calendarProvider;
    }
}