<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Domain\Event;

use Ticket\Domain\Event\DomainEvent;
use Ticket\Domain\Event\DomainEventSubscriber;
use Ticket\Infrastructure\Projection\Projector;

class ProjectDomainEventSubscriber implements DomainEventSubscriber
{
    private Projector $projector;

    public function __construct(Projector $projector)
    {
        $this->projector = $projector;
    }

    public function handle(DomainEvent $event): void
    {
        $this->projector->project($event);
    }

    public function isSubscribedTo(DomainEvent $event): bool
    {
        return true;
    }
}