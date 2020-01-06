<?php
declare(strict_types=1);

namespace User\Core\Shared\Application;

use User\Core\Application\Exception\PasswordCannotBeHashed;
use User\Core\Application\PasswordHashing;
use User\Core\Infrastructure\Shared\Domain\BcryptHashedPassword;
use User\Core\Shared\Domain\HashedPassword;

class BcryptPasswordHashing implements PasswordHashing
{
    public function encrypt(string $password): HashedPassword
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        if (!$hash) {
            throw PasswordCannotBeHashed::create();
        }

        return new BcryptHashedPassword($hash);
    }

    public function isPasswordValid(string $password, HashedPassword $hashedPassword): bool
    {
        return password_verify($password, (string)$hashedPassword);
    }
}
