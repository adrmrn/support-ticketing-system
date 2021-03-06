<?php
declare(strict_types=1);

namespace User\Core\Domain\User;

use User\Core\Domain\Exception\UserNotFound;
use User\Core\Domain\Email;

interface UserRepository
{
    public function nextIdentity(): UserId;
    public function add(User $user): void;

    /**
     * @param UserId $id
     * @return User
     * @throws UserNotFound
     */
    public function getById(UserId $id): User;
    public function existsByEmail(Email $email): bool;
}
