<?php
declare(strict_types=1);

namespace App\Events\UserRegistered;

use App\Events\Event;

class UserRegisteredEvent implements Event
{
    private string $userId;
    private string $email;
    private string $hashedPassword;
    private string $role;

    public function __construct(string $userId, string $email, string $hashedPassword, string $role)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
        $this->role = $role;
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function hashedPassword(): string
    {
        return $this->hashedPassword;
    }

    public function role(): string
    {
        return $this->role;
    }
}
