<?php
declare(strict_types=1);

namespace Ticket\Shared\Domain;

interface CalendarProvider
{
    public function now(): \DateTimeInterface;
}