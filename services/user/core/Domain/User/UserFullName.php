<?php
declare(strict_types=1);

namespace User\Core\Domain\User;

class UserFullName
{
    private const FIRST_NAME_MIN_LENGTH = 1;
    private const FIRST_NAME_MAX_LENGTH = 255;
    private const LAST_NAME_MIN_LENGTH = 1;
    private const LAST_NAME_MAX_LENGTH = 255;

    private string $firstName;
    private string $lastName;

    public function __construct(string $firstName, string $lastName)
    {
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    private function setFirstName(string $firstName): void
    {
        if (mb_strlen($firstName) < self::FIRST_NAME_MIN_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('First name must contains minimum %d characters.', self::FIRST_NAME_MIN_LENGTH)
            );
        }

        if (mb_strlen($firstName) > self::FIRST_NAME_MAX_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('First name must contains maximum %d characters.', self::FIRST_NAME_MAX_LENGTH)
            );
        }

        $this->firstName = $firstName;
    }

    private function setLastName(string $lastName): void
    {
        if (mb_strlen($lastName) < self::LAST_NAME_MIN_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('First name must contains minimum %d characters.', self::LAST_NAME_MIN_LENGTH)
            );
        }

        if (mb_strlen($lastName) > self::LAST_NAME_MAX_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('First name must contains maximum %d characters.', self::LAST_NAME_MAX_LENGTH)
            );
        }

        $this->lastName = $lastName;
    }
}
