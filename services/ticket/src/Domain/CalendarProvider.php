<?php
declare(strict_types=1);

namespace Ticket\Domain;

interface CalendarProvider
{
    public function now(): \DateTimeInterface;
}