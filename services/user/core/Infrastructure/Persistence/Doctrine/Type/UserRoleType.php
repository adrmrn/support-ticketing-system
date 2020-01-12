<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use User\Core\Domain\User\UserRole;

class UserRoleType extends StringType
{
    public const NAME = UserRole::class;

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        $value = parent::convertToDatabaseValue($value, $platform);
        return (string)$value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $value = parent::convertToPHPValue($value, $platform);
        switch ($value) {
            case 'customer':
                $role = UserRole::customer();
                break;

            case 'admin':
                $role = UserRole::admin();
                break;

            default:
                throw new \RuntimeException('Cannot create user role.');
        }

        return $role;
    }

    public function getName()
    {
        return self::NAME;
    }
}
