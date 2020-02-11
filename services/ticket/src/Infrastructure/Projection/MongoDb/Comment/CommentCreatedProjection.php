<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Projection\MongoDb\Comment;

use Ticket\Domain\Comment\Event\CommentCreated;
use Ticket\Domain\Event\DomainEvent;
use Ticket\Infrastructure\Persistence\MongoDb\MongoDbClient;
use Ticket\Infrastructure\Projection\Projection;

class CommentCreatedProjection implements Projection
{
    private MongoDbClient $client;

    public function __construct(MongoDbClient $client)
    {
        $this->client = $client;
    }

    public function isListeningTo(DomainEvent $event): bool
    {
        return \get_class($event) === CommentCreated::class;
    }

    public function project(DomainEvent $event): void
    {
        $this->client->push(
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