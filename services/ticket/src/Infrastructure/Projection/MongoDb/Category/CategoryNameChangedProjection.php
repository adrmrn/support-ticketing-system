<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Projection\MongoDb\Category;

use Ticket\Domain\Category\Event\CategoryNameChanged;
use Ticket\Domain\Event\DomainEvent;
use Ticket\Infrastructure\Projection\MongoDb\MongoDbProjection;

class CategoryNameChangedProjection extends MongoDbProjection
{
    public function isListeningTo(DomainEvent $event): bool
    {
        return \get_class($event) === CategoryNameChanged::class;
    }

    public function project(DomainEvent $event): void
    {
        $this->client()->update(
            'category',
            [
                'id' => $event->aggregateId()
            ],
            [
                'name' => $event->data()['name']
            ]
        );
    }
}