<?php
declare(strict_types=1);

namespace User\Core\Shared\Domain;

use User\Core\Shared\Domain\AggregateId;

interface DomainEvent
{
    public function aggregateId(): string;
    public function occurredOn(): \DateTimeInterface;
    public function dataAsJson(): string;
}
