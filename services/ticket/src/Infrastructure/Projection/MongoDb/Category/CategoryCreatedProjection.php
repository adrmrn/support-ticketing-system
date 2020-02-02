<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Projection\MongoDb\Category;

use Ticket\Domain\Category\Event\CategoryCreated;
use Ticket\Domain\Event\DomainEvent;
use Ticket\Infrastructure\Persistence\MongoDb\MongoDbClient;
use Ticket\Infrastructure\Projection\Projection;

class CategoryCreatedProjection implements Projection
{
    private MongoDbClient $client;

    public function __construct(MongoDbClient $client)
    {
        $this->client = $client;
    }

    public function isListeningTo(DomainEvent $event): bool
    {
        return \get_class($event) === CategoryCreated::class;
    }

    public function project(DomainEvent $event): void
    {
        $this->client->save(
            'category',
            [
                'id' => $event->aggregateId(),
                'name' => $event->data()['name']
            ]
        );
    }
}