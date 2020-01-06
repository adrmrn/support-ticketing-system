<?php
declare(strict_types=1);

namespace User\Core\Domain\Exception;

use Throwable;
use User\Core\Domain\UserId;

final class UserNotFound extends \Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function withUserId(UserId $userId): UserNotFound
    {
        return new self(
            sprintf('User not found. User ID: %s', (string)$userId)
        );
    }
}
