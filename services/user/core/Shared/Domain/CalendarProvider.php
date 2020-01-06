<?php
declare(strict_types=1);

namespace User\Core\Shared\Domain;

interface CalendarProvider
{
    public function now(): \DateTimeInterface;
}
