<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Exceptions\CredentialsNotFound;
use App\Models\BcryptHashedPassword;
use App\Models\Credentials;
use App\Models\Email;
use App\Models\UserId;
use Doctrine\DBAL\Connection;

class MySqlCredentialsRepository implements CredentialsRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getByEmail(Email $email): Credentials
    {
        $query = $this->connection->prepare("
            SELECT c.*
            FROM credentials AS c
            WHERE c.email = :email
        ");
        $query->bindValue(':email', (string)$email);
        $query->execute();
        if ($query->rowCount() === 0) {
            throw new CredentialsNotFound();
        }

        return $this->createCredentials($query->fetch());
    }

    public function doesEmailExist(Email $email): bool
    {
        $query = $this->connection->prepare("
            SELECT c.*
            FROM credentials AS c
            WHERE c.email = :email
        ");
        $query->bindValue(':email', (string)$email);
        $query->execute();
        return $query->rowCount() > 0;
    }

    public function store(Credentials $credentials): void
    {
        $query = $this->connection->prepare("
            INSERT INTO credentials
            (user_id, email, hashed_password)
            VALUES
            (:user_id, :email, :hashed_password)
        ");
        $query->bindValue(':user_id', (string)$credentials->userId());
        $query->bindValue(':email', (string)$credentials->email());
        $query->bindValue(':hashed_password', (string)$credentials->hashedPassword());
        $query->execute();
    }

    private function createCredentials(array $rawData): Credentials
    {
        return new Credentials(
            UserId::fromString($rawData['user_id']),
            new Email($rawData['email']),
            new BcryptHashedPassword($rawData['hashed_password'])
        );
    }
}
