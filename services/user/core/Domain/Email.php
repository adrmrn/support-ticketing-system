<?php
declare(strict_types=1);

namespace User\Core\Domain;

class Email
{
    private string $email;

    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Provided email is invalid.');
        }

        $this->email = $email;
    }

    public function __toString(): string
    {
        return $this->email;
    }
}
