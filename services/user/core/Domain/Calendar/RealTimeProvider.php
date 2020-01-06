<?php
declare(strict_types=1);

namespace User\Core\Domain\Calendar;

class RealTimeProvider implements CalendarProvider
{
    public function now(): \DateTimeInterface
    {
        return new \DateTimeImmutable();
    }
}
