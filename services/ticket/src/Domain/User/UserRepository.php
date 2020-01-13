<?php
declare(strict_types=1);

namespace Ticket\Domain\User;

use Ticket\Domain\Exception\UserNotFound;

interface UserRepository
{
    /**
     * @param UserId $id
     * @return User
     * @throws UserNotFound
     */
    public function getById(UserId $id): User;
}