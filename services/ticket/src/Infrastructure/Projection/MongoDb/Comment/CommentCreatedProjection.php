<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Projection\MongoDb\Comment;

use Ticket\Domain\Comment\Event\CommentCreated;
use Ticket\Domain\Event\DomainEvent;
use Ticket\Infrastructure\Projection\MongoDb\MongoDbProjection;

class CommentCreatedProjection extends MongoDbProjection
{
    public function isListeningTo(DomainEvent $event): bool
    {
        return \get_class($event) === CommentCreated::class;
    }

    public function project(DomainEvent $event): void
    {
        $this->client()->push(
            'ticket',
            [
                'id' => $event->data()['ticketId']
            ],
            [
                'comments' => [
                    'id' => $event->aggregateId(),
                    'content' => $event->data()['content'],
                    'author_id' => $event->data()['authorId'],
                    'created_at' => $event->data()['createdAt']
                ]
            ]
        );
    }
}