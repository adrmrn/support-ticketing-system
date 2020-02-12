<?php
declare(strict_types=1);

namespace Ticket\Domain;

class RealTimeProvider implements CalendarProvider
{
    public function now(): \DateTimeInterface
    {
        return new \DateTimeImmutable();
    }
}