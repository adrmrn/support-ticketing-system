<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\Helpers\Domain\Event;

use Ticket\Domain\Event\StoredEvent;

class TestableStoredEvent extends StoredEvent
{
    public function setId(int $eventId): void
    {
        $this->eventId = $eventId;
    }
}