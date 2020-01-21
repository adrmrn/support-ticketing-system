<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Delivery\Api\Authenticator;

use Symfony\Component\Security\Core\User\UserInterface;
use Ticket\Domain\User\User;
use Ticket\Domain\User\UserId;
use Ticket\Domain\User\UserRole;

class AuthenticatedUser implements UserInterface, User
{
    private UserId $userId;
    private UserRole $role;

    public function __construct(UserId $userId, UserRole $role)
    {
        $this->userId = $userId;
        $this->role = $role;
    }

    public function id(): UserId
    {
        return $this->userId;
    }

    public function role(): UserRole
    {
        return $this->role;
    }

    /**
     * @inheritDoc
     */
    public function getRoles(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getPassword(): ?string
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getUsername(): ?string
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        // do nothing
    }
}