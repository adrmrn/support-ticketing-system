<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\Helpers\Infrastructure\Domain\Event;

use Ticket\Domain\Event\DomainEvent;
use Ticket\Domain\Event\DomainEventSubscriber;

class FakeAlwaysSatisfiedDomainEventSubscriber implements DomainEventSubscriber
{
    private ?DomainEvent $lastHandledEvent = null;

    public function handle(DomainEvent $event): void
    {
        $this->lastHandledEvent = $event;
    }

    public function isSubscribedTo(DomainEvent $event): bool
    {
        return true;
    }

    public function hasBeenAnyEventHandled(): bool
    {
        return !\is_null($this->lastHandledEvent);
    }

    public function lastHandledEvent(): ?DomainEvent
    {
        return $this->lastHandledEvent;
    }
}