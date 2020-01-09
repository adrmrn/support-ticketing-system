<?php
declare(strict_types=1);

namespace App\Models;

class Credentials
{
    private UserId $userId;
    private Email $email;
    private HashedPassword $hashedPassword;

    public function __construct(UserId $userId, Email $email, HashedPassword $hashedPassword)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function hashedPassword(): HashedPassword
    {
        return $this->hashedPassword;
    }
}
