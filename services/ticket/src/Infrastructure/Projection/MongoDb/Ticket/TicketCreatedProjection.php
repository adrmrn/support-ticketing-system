<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Projection\MongoDb\Ticket;

use Ticket\Domain\Event\DomainEvent;
use Ticket\Domain\Ticket\Event\TicketCreated;
use Ticket\Domain\Ticket\TicketStatus;
use Ticket\Infrastructure\Projection\MongoDb\MongoDbProjection;

class TicketCreatedProjection extends MongoDbProjection
{
    public function isListeningTo(DomainEvent $event): bool
    {
        return \get_class($event) === TicketCreated::class;
    }

    public function project(DomainEvent $event): void
    {
        $this->client()->save(
            'ticket',
            [
                'id' => $event->aggregateId(),
                'title' => $event->data()['title'],
                'description' => $event->data()['description'],
                'category_id' => $event->data()['categoryId'],
                'author_id' => $event->data()['authorId'],
                'created_at' => $event->data()['createdAt'],
                'status' => (string)TicketStatus::open(),
                'comments' => []
            ]
        );
    }
}