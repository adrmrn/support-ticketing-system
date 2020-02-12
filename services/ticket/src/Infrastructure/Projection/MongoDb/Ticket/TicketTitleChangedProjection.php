<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Projection\MongoDb\Ticket;

use Ticket\Domain\Event\DomainEvent;
use Ticket\Domain\Ticket\Event\TicketTitleChanged;
use Ticket\Infrastructure\Projection\MongoDb\MongoDbProjection;

class TicketTitleChangedProjection extends MongoDbProjection
{
    public function isListeningTo(DomainEvent $event): bool
    {
        return \get_class($event) === TicketTitleChanged::class;
    }

    public function project(DomainEvent $event): void
    {
        $this->client()->update(
            'ticket',
            [
                'id' => $event->aggregateId()
            ],
            [
                'title' => $event->data()['title']
            ]
        );
    }
}