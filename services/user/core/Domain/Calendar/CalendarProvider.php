<?php
declare(strict_types=1);

namespace User\Core\Domain\Calendar;

interface CalendarProvider
{
    public function now(): \DateTimeInterface;
}
