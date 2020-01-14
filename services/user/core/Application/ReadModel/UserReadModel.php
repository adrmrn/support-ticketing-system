<?php
declare(strict_types=1);

namespace User\Core\Application\ReadModel;

class UserReadModel
{
    private string $id;
    private string $email;
    private string $firstName;
    private string $lastName;
    private string $role;

    public function __construct(string $id, string $email, string $firstName, string $lastName, string $role)
    {
        $this->id = $id;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->role = $role;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'role' => $this->role
        ];
    }
}
