<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Domain\Service;

use Doctrine\DBAL\Connection;
use Ticket\Domain\Calendar;
use Ticket\Domain\Service\FindOverdueTickets;
use Ticket\Domain\Ticket\Ticket;
use Ticket\Domain\Ticket\TicketId;
use Ticket\Domain\Time;

class MySqlFindOverdueTickets implements FindOverdueTickets
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @inheritDoc
     */
    public function execute(Time $overdueLimit): array
    {
        $overdueTimestamp = time() - $overdueLimit->seconds();
        $overdueDate = (new \DateTime())->setTimestamp($overdueTimestamp);
        $result = $this->connection->executeQuery("
            SELECT t.id
            FROM tickets AS t
            JOIN (
                 SELECT c.*, ROW_NUMBER() OVER(
                    PARTITION BY c.ticket_id
                    ORDER BY c.created_at DESC
                 ) AS commentOrderNumber
                 FROM comments AS c
            ) AS c
            ON t.id = c.ticket_id
            WHERE c.commentOrderNumber = 1
              AND t.author_id != c.author_id
              AND t.status = 'open'
              AND c.created_at < :created_at
        ", [
            ':created_at' => $overdueDate->format(Calendar::DEFAULT_DATE_FORMAT)
        ]);

        return array_map(
            fn(array $ticketRawData) => TicketId::fromString($ticketRawData['id']),
            $result->fetchAll()
        );
    }
}