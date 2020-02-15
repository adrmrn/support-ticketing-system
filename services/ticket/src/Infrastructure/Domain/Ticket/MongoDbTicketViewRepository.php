<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Domain\Ticket;

use MongoDB\Model\BSONDocument;
use Ticket\Domain\Comment\CommentView;
use Ticket\Domain\Criterion;
use Ticket\Domain\Ticket\TicketView;
use Ticket\Domain\Ticket\TicketViewRepository;
use Ticket\Infrastructure\Persistence\MongoDb\MongoDbClient;

class MongoDbTicketViewRepository implements TicketViewRepository
{
    private MongoDbClient $client;

    public function __construct(MongoDbClient $client)
    {
        $this->client = $client;
    }

    /**
     * @inheritDoc
     */
    public function getAll(Criterion ...$criteria): array
    {
        $filters = [];
        foreach ($criteria as $criterion) {
            $filters[$criterion->property()] = $criterion->value();
        }

        $ticketsRawData = $this->client->find(
            'ticket',
            $filters
        );
        return array_map(function (array $ticketRawData) {
            return $this->createTicketView($ticketRawData);
        }, $ticketsRawData);
    }

    private function createTicketView(array $ticketRawData): TicketView
    {
        return new TicketView(
            $ticketRawData['id'],
            $ticketRawData['title'],
            $ticketRawData['description'],
            $ticketRawData['category_id'],
            $ticketRawData['author_id'],
            $ticketRawData['status'],
            $ticketRawData['created_at'],
            array_map(
                fn(BSONDocument $comment) => $this->createCommentView($comment->getArrayCopy()),
                $ticketRawData['comments']->getArrayCopy()
            )
        );
    }

    private function createCommentView(array $commentRawData): CommentView
    {
        return new CommentView(
            $commentRawData['id'],
            $commentRawData['content'],
            $commentRawData['author_id'],
            $commentRawData['created_at']
        );
    }
}