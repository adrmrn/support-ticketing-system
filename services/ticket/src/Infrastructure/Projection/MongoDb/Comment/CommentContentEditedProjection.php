<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Projection\MongoDb\Comment;

use Ticket\Domain\Comment\Event\CommentContentEdited;
use Ticket\Domain\Event\DomainEvent;
use Ticket\Infrastructure\Persistence\MongoDb\MongoDbClient;
use Ticket\Infrastructure\Projection\Projection;

class CommentContentEditedProjection implements Projection
{
    private MongoDbClient $client;

    public function __construct(MongoDbClient $client)
    {
        $this->client = $client;
    }

    public function isListeningTo(DomainEvent $event): bool
    {
        return \get_class($event) === CommentContentEdited::class;
    }

    public function project(DomainEvent $event): void
    {
        $this->client->update(
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