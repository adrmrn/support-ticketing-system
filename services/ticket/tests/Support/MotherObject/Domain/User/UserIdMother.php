<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\User;

use Ticket\Domain\User\UserId;

final class UserIdMother
{
    public static function create(string $id): UserId
    {
        return UserId::fromString($id);
    }

    public static function createDefault(): UserId
    {
        return UserId::fromString('ID-USER-1');
    }
}