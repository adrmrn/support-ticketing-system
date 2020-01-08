<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Messaging;

use User\Core\Domain\Event\StoredEvent;

interface PublishedMessageTracker
{
    public function mostRecentPublishedEventId(string $exchangeName): int;

    public function trackMostRecentPublishedMessage(string $exchangeName, StoredEvent $storedEvent): void;
}
