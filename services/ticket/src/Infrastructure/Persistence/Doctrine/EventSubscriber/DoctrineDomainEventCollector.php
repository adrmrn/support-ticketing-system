<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Persistence\Doctrine\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Ticket\Domain\Category\Category;
use Ticket\Domain\Category\Event\CategoryRemoved;
use Ticket\Domain\Comment\Comment;
use Ticket\Domain\Comment\Event\CommentRemoved;
use Ticket\Domain\Event\DomainEvent;
use Ticket\Domain\Event\DomainEventDispatcher;
use Ticket\Domain\Aggregate;

final class DoctrineDomainEventCollector implements EventSubscriber
{
    private DomainEventDispatcher $domainEventDispatcher;
    /**
     * @var DomainEvent[]
     */
    private array $raisedEvents = [];

    public function __construct(DomainEventDispatcher $domainEventDispatcher)
    {
        $this->domainEventDispatcher = $domainEventDispatcher;
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $this->collectRaisedEvents($args);
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $this->collectRaisedEvents($args);
    }

    public function postRemove(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        if ($entity instanceof Category) {
            $this->raisedEvents[] = new CategoryRemoved($entity->id());
        } elseif ($entity instanceof Comment) {
            $this->raisedEvents[] = new CommentRemoved($entity->id());
        }
    }

    private function collectRaisedEvents(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        if (!($entity instanceof Aggregate)) {
            return;
        }

        /** @var Aggregate $entity */
        foreach ($entity->popRaisedEvents() as $raisedEvent) {
            $this->raisedEvents[] = $raisedEvent;
        }
    }

    public function dispatchRaisedEvents(): void
    {
        $raisedEvents = $this->raisedEvents;
        $this->raisedEvents = [];

        foreach ($raisedEvents as $raisedEvent) {
            $this->domainEventDispatcher->dispatch($raisedEvent);
        }

        if ($this->hasUndispatchedRaisedEvents()) {
            $this->dispatchRaisedEvents();
        }
    }

    public function hasUndispatchedRaisedEvents(): bool
    {
        return \count($this->raisedEvents) > 0;
    }

    /**
     * @inheritDoc
     */
    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
            Events::postUpdate,
            Events::postRemove
        ];
    }
}