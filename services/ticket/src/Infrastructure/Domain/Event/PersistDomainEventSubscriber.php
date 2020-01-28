<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Domain\Event;

use Ticket\Domain\Event\DomainEvent;
use Ticket\Domain\Event\DomainEventSubscriber;
use Ticket\Domain\Event\EventStore;

class PersistDomainEventSubscriber implements DomainEventSubscriber
{
    private EventStore $eventStore;

    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    public function handle(DomainEvent $event): void
    {
        $this->eventStore->append($event);
    }

    public function isSubscribedTo(DomainEvent $event): bool
    {
        return true;
    }
}