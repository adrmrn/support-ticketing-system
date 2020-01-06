<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Domain\Event;

use User\Core\Domain\Event\DomainEvent;
use User\Core\Domain\Event\DomainEventSubscriber;
use User\Core\Domain\Event\EventStore;

class PersistDomainEventSubscriber implements DomainEventSubscriber
{
    /**
     * @var EventStore
     */
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
