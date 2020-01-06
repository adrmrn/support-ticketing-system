<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Shared\Domain;

use User\Core\Shared\Domain\HashedPassword;

class BcryptHashedPassword implements HashedPassword
{
    private const BCRYPT_PASSWORD_LENGTH = 60;

    private string $hash;

    public function __construct(string $hash)
    {
        if (mb_strlen($hash) !== self::BCRYPT_PASSWORD_LENGTH) {
            throw new \InvalidArgumentException(
                'Provided bcrypt hashed password is invalid.'
            );
        }

        $this->hash = $hash;
    }

    public function __toString(): string
    {
        return $this->hash;
    }
}
