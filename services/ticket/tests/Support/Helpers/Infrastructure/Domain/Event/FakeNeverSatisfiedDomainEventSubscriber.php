<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\Helpers\Infrastructure\Domain\Event;

use Ticket\Domain\Event\DomainEvent;
use Ticket\Domain\Event\DomainEventSubscriber;

class FakeNeverSatisfiedDomainEventSubscriber implements DomainEventSubscriber
{
    private bool $hasBeenAnyEventHandled = false;

    public function handle(DomainEvent $event): void
    {
        $this->hasBeenAnyEventHandled = true;
    }

    public function isSubscribedTo(DomainEvent $event): bool
    {
        return false;
    }

    public function hasBeenAnyEventHandled(): bool
    {
        return $this->hasBeenAnyEventHandled;
    }
}