<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Projection\MongoDb\Comment;

use Ticket\Domain\Comment\Event\CommentContentEdited;
use Ticket\Domain\Event\DomainEvent;
use Ticket\Infrastructure\Projection\MongoDb\MongoDbProjection;

class CommentContentEditedProjection extends MongoDbProjection
{
    public function isListeningTo(DomainEvent $event): bool
    {
        return \get_class($event) === CommentContentEdited::class;
    }

    public function project(DomainEvent $event): void
    {
        $this->client()->update(
            'ticket',
            [
                'comments.id' => $event->aggregateId()
            ],
            [
                'comments.$.content' => $event->data()['content']
            ]
        );
    }
}