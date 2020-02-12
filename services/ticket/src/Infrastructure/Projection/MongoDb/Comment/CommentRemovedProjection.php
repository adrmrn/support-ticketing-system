<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Projection\MongoDb\Comment;

use Ticket\Domain\Comment\Event\CommentRemoved;
use Ticket\Domain\Event\DomainEvent;
use Ticket\Infrastructure\Projection\MongoDb\MongoDbProjection;

class CommentRemovedProjection extends MongoDbProjection
{
    public function isListeningTo(DomainEvent $event): bool
    {
        return \get_class($event) === CommentRemoved::class;
    }

    public function project(DomainEvent $event): void
    {
        $this->client()->pull(
            'ticket',
            [],
            [
                'comments' => [
                    'id' => $event->aggregateId()
                ]
            ]
        );
    }
}