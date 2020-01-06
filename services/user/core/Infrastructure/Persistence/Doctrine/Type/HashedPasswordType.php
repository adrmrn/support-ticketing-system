<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use User\Core\Infrastructure\Shared\Domain\BcryptHashedPassword;
use User\Core\Shared\Domain\HashedPassword;

class HashedPasswordType extends StringType
{
    public const NAME = HashedPassword::class;

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        $value = parent::convertToDatabaseValue($value, $platform);
        return (string)$value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $value = parent::convertToPHPValue($value, $platform);
        return new BcryptHashedPassword($value);
    }

    public function getName()
    {
        return self::NAME;
    }
}
