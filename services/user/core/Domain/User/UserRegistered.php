<?php
declare(strict_types=1);

namespace User\Core\Domain\User;

use User\Core\Domain\Calendar\Calendar;
use User\Core\Domain\Event\DomainEvent;
use User\Core\Domain\Email;
use User\Core\Domain\HashedPassword;

class UserRegistered implements DomainEvent
{
    private UserId $userId;
    private UserFullName $fullName;
    private Email $email;
    private HashedPassword $hashedPassword;
    private UserRole $role;
    private \DateTimeInterface $occurredOn;

    public function __construct(
        UserId $userId,
        UserFullName $fullName,
        Email $email,
        HashedPassword $hashedPassword,
        UserRole $role
    ) {
        $this->userId = $userId;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
        $this->role = $role;
        $this->occurredOn = Calendar::now();
    }

    public function aggregateId(): string
    {
        return (string)$this->userId;
    }

    public function occurredOn(): \DateTimeInterface
    {
        return $this->occurredOn;
    }

    public function version(): int
    {
        return 0;
    }

    public function dataAsJson(): string
    {
        return \json_encode([
            'id' => (string)$this->userId,
            'fullName' => [
                'firstName' => $this->fullName->firstName(),
                'lastName' => $this->fullName->lastName()
            ],
            'email' => (string)$this->email,
            'hashedPassword' => (string)$this->hashedPassword,
            'role' => (string)$this->role
        ]);
    }
}
