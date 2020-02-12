<?php
declare(strict_types=1);

namespace Ticket\Domain;

use Ticket\Domain\Event\DomainEvent;

abstract class Aggregate
{
    /**
     * @var DomainEvent[]
     */
    private array $raisedEvents = [];

    public function popRaisedEvents(): array
    {
        $raisedEvents = $this->raisedEvents;
        $this->raisedEvents = [];
        return $raisedEvents;
    }

    protected function raiseEvent(DomainEvent $event): void
    {
        $this->raisedEvents[] = $event;
    }
}