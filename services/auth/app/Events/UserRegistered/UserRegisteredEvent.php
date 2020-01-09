<?php
declare(strict_types=1);

namespace App\Events\UserRegistered;

use App\Events\Event;

class UserRegisteredEvent implements Event
{
    private string $userId;
    private string $email;
    private string $hashedPassword;

    public function __construct(string $userId, string $email, string $hashedPassword)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
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
}
