<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Ticket\Domain\Ticket\TicketTitle;

class TicketTitleType extends StringType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        $value = parent::convertToDatabaseValue($value, $platform);
        return (string)$value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $value = parent::convertToPHPValue($value, $platform);
        return new TicketTitle($value);
    }

    public function getName()
    {
        return TicketTitle::class;
    }
}