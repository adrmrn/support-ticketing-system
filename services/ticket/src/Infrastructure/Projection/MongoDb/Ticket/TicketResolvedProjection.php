<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Projection\MongoDb\Ticket;

use Ticket\Domain\Event\DomainEvent;
use Ticket\Domain\Ticket\Event\TicketResolved;
use Ticket\Domain\Ticket\TicketStatus;
use Ticket\Infrastructure\Projection\MongoDb\MongoDbProjection;

class TicketResolvedProjection extends MongoDbProjection
{
    public function isListeningTo(DomainEvent $event): bool
    {
        return \get_class($event) === TicketResolved::class;
    }

    public function project(DomainEvent $event): void
    {
        $this->client()->update(
            'ticket',
            [
                'id' => $event->aggregateId()
            ],
            [
                'status' => (string)TicketStatus::resolved()
            ]
        );
    }
}