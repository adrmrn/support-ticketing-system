<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Projection\MongoDb\Category;

use Ticket\Domain\Category\Event\CategoryRemoved;
use Ticket\Domain\Event\DomainEvent;
use Ticket\Infrastructure\Projection\MongoDb\MongoDbProjection;

class CategoryRemovedProjection extends MongoDbProjection
{
    public function isListeningTo(DomainEvent $event): bool
    {
        return \get_class($event) === CategoryRemoved::class;
    }

    public function project(DomainEvent $event): void
    {
        $this->client()->delete('category', [
            'id' => $event->aggregateId()
        ]);
    }
}