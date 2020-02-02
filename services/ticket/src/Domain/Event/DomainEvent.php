<?php
declare(strict_types=1);

namespace Ticket\Domain\Event;

interface DomainEvent
{
    public function aggregateId(): string;
    public function occurredOn(): \DateTimeInterface;
    public function version(): int;
    public function data(): array;
    public function dataAsJson(): string;
}