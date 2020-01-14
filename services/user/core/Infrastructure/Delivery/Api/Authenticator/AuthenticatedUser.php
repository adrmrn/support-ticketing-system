<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Delivery\Api\Authenticator;

use User\Core\Domain\User\UserId;

class AuthenticatedUser
{
    private UserId $id;

    public function __construct(UserId $id)
    {
        $this->id = $id;
    }

    public function id(): UserId
    {
        return $this->id;
    }
}
