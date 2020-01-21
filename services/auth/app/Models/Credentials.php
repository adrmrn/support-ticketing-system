<?php
declare(strict_types=1);

namespace App\Models;

class Credentials
{
    private UserId $userId;
    private Email $email;
    private HashedPassword $hashedPassword;
    private AccountType $accountType;

    public function __construct(UserId $userId, Email $email, HashedPassword $hashedPassword, AccountType $accountType)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
        $this->accountType = $accountType;
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

    public function accountType(): AccountType
    {
        return $this->accountType;
    }
}
