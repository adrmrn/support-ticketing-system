<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\Helpers\Domain\User;

use Ticket\Domain\User\User;
use Ticket\Domain\User\UserId;
use Ticket\Domain\User\UserRole;

class FakeUser implements User
{
    private UserId $id;
    private UserRole $role;

    public function __construct(UserId $id, UserRole $role)
    {
        $this->id = $id;
        $this->role = $role;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function role(): UserRole
    {
        return $this->role;
    }
}