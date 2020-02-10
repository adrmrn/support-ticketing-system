<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Projection\MongoDb\Ticket;

use Ticket\Domain\Event\DomainEvent;
use Ticket\Domain\Ticket\Event\TicketTitleChanged;
use Ticket\Infrastructure\Persistence\MongoDb\MongoDbClient;
use Ticket\Infrastructure\Projection\Projection;

class TicketTitleChangedProjection implements Projection
{
    private MongoDbClient $client;

    public function __construct(MongoDbClient $client)
    {
        $this->client = $client;
    }

    public function isListeningTo(DomainEvent $event): bool
    {
        return \get_class($event) === TicketTitleChanged::class;
    }

    public function project(DomainEvent $event): void
    {
        $this->client->update(
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