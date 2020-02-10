<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Projection\MongoDb\Ticket;

use Ticket\Domain\Event\DomainEvent;
use Ticket\Domain\Ticket\Event\TicketCreated;
use Ticket\Domain\Ticket\TicketStatus;
use Ticket\Infrastructure\Persistence\MongoDb\MongoDbClient;
use Ticket\Infrastructure\Projection\Projection;

class TicketCreatedProjection implements Projection
{
    private MongoDbClient $client;

    public function __construct(MongoDbClient $client)
    {
        $this->client = $client;
    }

    public function isListeningTo(DomainEvent $event): bool
    {
        return \get_class($event) === TicketCreated::class;
    }

    public function project(DomainEvent $event): void
    {
        $this->client->save(
            'ticket',
            [
                'id' => $event->aggregateId(),
                'title' => $event->data()['title'],
                'description' => $event->data()['description'],
                'category_id' => $event->data()['categoryId'],
                'author_id' => $event->data()['authorId'],
                'status' => (string)TicketStatus::open()
            ]
        );
    }
}