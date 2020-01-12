<?php
declare(strict_types=1);

namespace User\Core\Domain\User;

use User\Core\Domain\Event\DomainEventPublisher;
use User\Core\Domain\Email;
use User\Core\Domain\HashedPassword;

class User
{
    private UserId $id;
    /**
     * There is problem with Doctrine for PHP 7.4
     * So I can't use typed property. Waiting for fix.
     * "Typed property must not be accessed before initialization"
     *
     * @var UserFullName
     */
    private $fullName;
    private Email $email;
    private HashedPassword $hashedPassword;
    private UserRole $role;

    public function __construct(
        UserId $id,
        UserFullName $fullName,
        Email $email,
        HashedPassword $hashedPassword,
        UserRole $role
    ) {
        $this->id = $id;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
        $this->role = $role;

        DomainEventPublisher::instance()->publish(
            new UserRegistered(
                $this->id(),
                $this->fullName(),
                $this->email(),
                $this->hashedPassword(),
                $this->role()
            )
        );
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

    public function role(): UserRole
    {
        return $this->role;
    }
}
