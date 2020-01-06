<?php
declare(strict_types=1);

namespace User\Core\Shared\Domain;

class RealTimeProvider implements CalendarProvider
{
    public function now(): \DateTimeInterface
    {
        return new \DateTimeImmutable();
    }
}
