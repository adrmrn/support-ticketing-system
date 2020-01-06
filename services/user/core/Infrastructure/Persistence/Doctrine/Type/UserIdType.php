<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use User\Core\Domain\UserId;

class UserIdType extends StringType
{
    public const NAME = UserId::class;

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        $value = parent::convertToDatabaseValue($value, $platform);
        return (string)$value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $value = parent::convertToPHPValue($value, $platform);
        return UserId::fromString($value);
    }

    public function getName()
    {
        return self::NAME;
    }
}
