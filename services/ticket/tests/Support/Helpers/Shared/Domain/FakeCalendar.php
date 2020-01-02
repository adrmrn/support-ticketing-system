<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\Helpers\Shared\Domain;

use Ticket\Shared\Domain\Calendar;
use Ticket\Shared\Domain\CalendarProvider;

class FakeCalendar extends Calendar
{
    private static ?CalendarProvider $oldCalendarProvider = null;

    public static function setFakeDate(string $dateString): void
    {
        static::$oldCalendarProvider = static::$calendarProvider;
        static::$calendarProvider = FakeCalendarProvider::fromDateString($dateString);
    }

    public static function destroy(): void
    {
        if (static::$calendarProvider instanceof FakeCalendarProvider) {
            static::$calendarProvider = static::$oldCalendarProvider;
        }
    }
}