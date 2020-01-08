<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Messaging;

use Doctrine\DBAL\Connection;
use User\Core\Domain\Event\StoredEvent;

class MySqlPublishedMessageTracker implements PublishedMessageTracker
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function mostRecentPublishedEventId(string $exchangeName): int
    {
        $query = $this->connection->prepare("
            SELECT mt.last_published_event_id
            FROM message_tracker AS mt
            WHERE mt.exchange_name = :exchangeName
        ");
        $query->bindValue(':exchangeName', $exchangeName);
        $query->execute();
        if ($query->rowCount() === 0) {
            return 0;
        }

        return (int)$query->fetch()['last_published_event_id'];
    }

    public function trackMostRecentPublishedMessage(string $exchangeName, StoredEvent $storedEvent): void
    {
        $numberOfAffectedRows = $this->connection->executeUpdate("
            UPDATE message_tracker
            SET last_published_event_id = :eventId,
                occurred_on = :occurredOn
            WHERE exchange_name = :exchangeName
        ", [
            ':exchangeName' => $exchangeName,
            ':eventId' => $storedEvent->eventId(),
            ':occurredOn' => (new \DateTimeImmutable())->format('Y-m-d H:i:s')
        ]);

        if ($numberOfAffectedRows === 0) {
            $this->connection->executeUpdate("
                INSERT INTO message_tracker
                (exchange_name, last_published_event_id, occurred_on)
                VALUES
                (:exchangeName, :eventId, :occurredOn)
            ", [
                ':exchangeName' => $exchangeName,
                ':eventId' => $storedEvent->eventId(),
                ':occurredOn' => (new \DateTimeImmutable())->format('Y-m-d H:i:s')
            ]);
        }
    }
}
