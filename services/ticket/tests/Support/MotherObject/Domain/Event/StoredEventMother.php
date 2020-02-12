<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\Event;

use Ticket\Domain\Event\StoredEvent;
use Ticket\Tests\Support\Helpers\Domain\Event\TestableStoredEvent;

class StoredEventMother
{
    public static function create(
        int $eventId,
        string $eventName,
        string $aggregateId,
        \DateTimeInterface $occurredOn,
        int $version,
        string $dataAsJson
    ): StoredEvent {
        $storedEvent = new TestableStoredEvent(
            $eventName,
            $aggregateId,
            $occurredOn,
            $version,
            $dataAsJson
        );
        $storedEvent->setId($eventId);
        return $storedEvent;
    }
}