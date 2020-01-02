<?php
declare(strict_types=1);

namespace Ticket\Shared\Domain;

class RealTimeProvider implements CalendarProvider
{
    public function now(): \DateTimeInterface
    {
        return new \DateTimeImmutable();
    }
}