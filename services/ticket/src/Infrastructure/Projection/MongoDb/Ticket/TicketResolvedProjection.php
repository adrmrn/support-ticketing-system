<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Projection\MongoDb\Ticket;

use Ticket\Domain\Event\DomainEvent;
use Ticket\Domain\Ticket\Event\TicketResolved;
use Ticket\Domain\Ticket\TicketStatus;
use Ticket\Infrastructure\Persistence\MongoDb\MongoDbClient;
use Ticket\Infrastructure\Projection\Projection;

class TicketResolvedProjection implements Projection
{
    private MongoDbClient $client;

    public function __construct(MongoDbClient $client)
    {
        $this->client = $client;
    }

    public function isListeningTo(DomainEvent $event): bool
    {
        return \get_class($event) === TicketResolved::class;
    }

    public function project(DomainEvent $event): void
    {
        $this->client->update(
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