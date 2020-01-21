<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\User;

use Ticket\Domain\User\User;
use Ticket\Domain\User\UserRole;
use Ticket\Tests\Support\Helpers\Domain\User\FakeUser;

class UserMother
{
    public static function createWithParams(array $params = []): User
    {
        $id = $params['id'] ?? UserIdMother::createDefault();
        $role = $params['role'] ?? UserRole::customer();

        return new FakeUser(
            $id,
            $role
        );
    }

    public static function createDefault(): User
    {
        return self::createCustomer();
    }

    public static function createCustomer(): User
    {
        return new FakeUser(
            UserIdMother::createDefault(),
            UserRole::customer()
        );
    }

    public static function createAdmin(): User
    {
        return new FakeUser(
            UserIdMother::createDefault(),
            UserRole::admin()
        );
    }
}