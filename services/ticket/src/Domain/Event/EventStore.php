<?php
declare(strict_types=1);

namespace Ticket\Domain\Event;

interface EventStore
{
    public function append(DomainEvent $event);

    /**
     * @param int $eventId
     * @return StoredEvent[]
     */
    public function allStoredEventsSince(int $eventId): array;
}