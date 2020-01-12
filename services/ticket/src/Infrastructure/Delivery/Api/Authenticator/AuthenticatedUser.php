<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Delivery\Api\Authenticator;

use Symfony\Component\Security\Core\User\UserInterface;
use Ticket\Domain\User\UserId;

class AuthenticatedUser implements UserInterface
{
    private UserId $userId;

    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
    }

    public function id(): UserId
    {
        return $this->userId;
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