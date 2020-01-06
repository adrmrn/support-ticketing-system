<?php
declare(strict_types=1);

namespace User\Core\Domain;

use User\Core\Shared\Domain\Calendar;
use User\Core\Shared\Domain\DomainEvent;
use User\Core\Shared\Domain\AggregateId;
use User\Core\Shared\Domain\Email;
use User\Core\Shared\Domain\HashedPassword;
use User\Core\Shared\Domain\Identifier;

class UserCreated implements DomainEvent
{
    private UserId $userId;
    private UserFullName $fullName;
    private Email $email;
    private HashedPassword $hashedPassword;
    private \DateTimeInterface $occurredOn;

    public function __construct(
        UserId $userId,
        UserFullName $fullName,
        Email $email,
        HashedPassword $hashedPassword
    ) {
        $this->userId = $userId;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
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

    public function dataAsJson(): string
    {
        return \json_encode([
            'id' => (string)$this->userId,
            'fullName' => [
                'firstName' => $this->fullName->firstName(),
                'lastName' => $this->fullName->lastName()
            ],
            'email' => (string)$this->email,
            'hashedPassword' => (string)$this->hashedPassword
        ]);
    }
}
