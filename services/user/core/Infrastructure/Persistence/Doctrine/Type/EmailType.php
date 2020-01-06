<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use User\Core\Shared\Domain\Email;

class EmailType extends StringType
{
    public const NAME = Email::class;

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        $value = parent::convertToDatabaseValue($value, $platform);
        return (string)$value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $value = parent::convertToPHPValue($value, $platform);
        return new Email($value);
    }

    public function getName()
    {
        return self::NAME;
    }
}
