<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Projection\MongoDb\Ticket;

use Ticket\Domain\Event\DomainEvent;
use Ticket\Domain\Ticket\Event\TicketClosed;
use Ticket\Domain\Ticket\TicketStatus;
use Ticket\Infrastructure\Projection\MongoDb\MongoDbProjection;

class TicketClosedProjection extends MongoDbProjection
{
    public function isListeningTo(DomainEvent $event): bool
    {
        return \get_class($event) === TicketClosed::class;
    }

    public function project(DomainEvent $event): void
    {
        $this->client()->update(
            'ticket',
            [
                'id' => $event->aggregateId()
            ],
            [
                'status' => (string)TicketStatus::closed()
            ]
        );
    }
}