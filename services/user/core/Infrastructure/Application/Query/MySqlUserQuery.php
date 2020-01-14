<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Application\Query;

use Doctrine\DBAL\Connection;
use User\Core\Application\Exception\UserNotFound;
use User\Core\Application\Query\UserQuery;
use User\Core\Application\ReadModel\UserReadModel;

class MySqlUserQuery implements UserQuery
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @inheritDoc
     */
    public function getById(string $id): UserReadModel
    {
        $query = $this->connection->prepare("
            SELECT u.*
            FROM users AS u
            WHERE u.id = :id
        ");
        $query->bindValue(':id', $id);
        $query->execute();
        if ($query->rowCount() === 0) {
            throw UserNotFound::withUserId($id);
        }

        return $this->createUserReadModel($query->fetch());
    }

    private function createUserReadModel(array $rawData): UserReadModel
    {
        return new UserReadModel(
            $rawData['id'],
            $rawData['email'],
            $rawData['first_name'],
            $rawData['last_name'],
            $rawData['role']
        );
    }
}
