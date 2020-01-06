<?php
declare(strict_types=1);

namespace User\Core\Application;

use User\Core\Application\Exception\PasswordCannotBeHashed;
use User\Core\Domain\HashedPassword;

interface PasswordHashing
{
    /**
     * @param string $password
     * @return HashedPassword
     * @throws PasswordCannotBeHashed
     */
    public function encrypt(string $password): HashedPassword;
    public function isPasswordValid(string $password, HashedPassword $hashedPassword): bool;
}
