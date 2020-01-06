<?php
declare(strict_types=1);

namespace User\Core\Shared\Domain\Event;

use User\Core\Shared\Domain\DomainEvent;

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

    public function isSubscribedTo(DomainEvent $event): bool
    {
        return true;
    }

    public function handle(DomainEvent $event): void
    {
        $this->eventStore->append($event);
    }
}
