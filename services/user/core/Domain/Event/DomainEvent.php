<?php
declare(strict_types=1);

namespace User\Core\Domain\Event;

interface DomainEvent
{
    public function aggregateId(): string;
    public function occurredOn(): \DateTimeInterface;
    public function version(): int;
    public function dataAsJson(): string;
}
