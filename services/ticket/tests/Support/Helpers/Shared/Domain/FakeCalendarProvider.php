<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\Helpers\Shared\Domain;

use Ticket\Domain\CalendarProvider;

class FakeCalendarProvider implements CalendarProvider
{
    private string $dateString;

    private function __construct(string $dateString)
    {
        $this->dateString = $dateString;
    }

    public function now(): \DateTimeInterface
    {
        return new \DateTimeImmutable($this->dateString);
    }

    public static function fromDateString(string $dateString): CalendarProvider
    {
        return new static($dateString);
    }
}