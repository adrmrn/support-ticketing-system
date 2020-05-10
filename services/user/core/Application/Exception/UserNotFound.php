<?php
declare(strict_types=1);

namespace User\Core\Application\Exception;

use Throwable;

final class UserNotFound extends NotFoundException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function withUserId(string $userId): UserNotFound
    {
        return new self(
            sprintf('User not found. User ID: %s', $userId)
        );
    }
}
