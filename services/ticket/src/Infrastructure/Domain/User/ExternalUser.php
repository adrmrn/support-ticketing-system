<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Domain\User;

use Ticket\Domain\User\User;
use Ticket\Domain\User\UserId;
use Ticket\Domain\User\UserRole;

class ExternalUser implements User
{
    private string $id;
    private string $firstName;
    private string $lastName;
    private string $role;

    public function __construct(string $id, string $firstName, string $lastName, string $role)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->role = $role;
    }

    public function id(): UserId
    {
        return UserId::fromString($this->id);
    }

    public function role(): UserRole
    {
        return UserRole::{$this->role}();
    }

    public function fullName(): string
    {
        return sprintf('%s %s', $this->firstName, $this->lastName);
    }
}