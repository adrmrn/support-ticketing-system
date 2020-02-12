<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Projection\MongoDb\Ticket;

use Ticket\Domain\Event\DomainEvent;
use Ticket\Domain\Ticket\Event\TicketDescribed;
use Ticket\Infrastructure\Projection\MongoDb\MongoDbProjection;

class TicketDescribedProjection extends MongoDbProjection
{
    public function isListeningTo(DomainEvent $event): bool
    {
        return \get_class($event) === TicketDescribed::class;
    }

    public function project(DomainEvent $event): void
    {
        $this->client()->update(
            'ticket',
            [
                'id' => $event->aggregateId()
            ],
            [
                'description' => $event->data()['description']
            ]
        );
    }
}