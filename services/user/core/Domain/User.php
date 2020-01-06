<?php
declare(strict_types=1);

namespace User\Core\Domain;

use User\Core\Shared\Domain\Email;
use User\Core\Shared\Domain\HashedPassword;

class User
{
    private UserId $id;
    private UserFullName $fullName;
    private Email $email;
    private HashedPassword $hashedPassword;

    public function __construct(UserId $id, UserFullName $fullName, Email $email, HashedPassword $hashedPassword)
    {
        $this->id = $id;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function fullName(): UserFullName
    {
        return $this->fullName;
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
