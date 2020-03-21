<?php
declare(strict_types=1);

namespace User\Core\Application\UseCase\RegisterAdmin;

class RegisterAdminRequest
{
    private string $email;
    private string $firstName;
    private string $lastName;
    private string $password;

    public function __construct(string $email, string $firstName, string $lastName, string $password)
    {
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->password = $password;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function password(): string
    {
        return $this->password;
    }
}
