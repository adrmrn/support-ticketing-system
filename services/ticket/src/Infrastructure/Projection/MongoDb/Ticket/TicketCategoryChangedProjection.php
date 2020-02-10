<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Projection\MongoDb\Ticket;

use Ticket\Domain\Event\DomainEvent;
use Ticket\Domain\Ticket\Event\TicketCategoryChanged;
use Ticket\Infrastructure\Persistence\MongoDb\MongoDbClient;
use Ticket\Infrastructure\Projection\Projection;

class TicketCategoryChangedProjection implements Projection
{
    private MongoDbClient $client;

    public function __construct(MongoDbClient $client)
    {
        $this->client = $client;
    }

    public function isListeningTo(DomainEvent $event): bool
    {
        return \get_class($event) === TicketCategoryChanged::class;
    }

    public function project(DomainEvent $event): void
    {
        $this->client->update(
            'ticket',
            [
                'id' => $event->aggregateId()
            ],
            [
                'category_id' => $event->data()['categoryId']
            ]
        );
    }
}