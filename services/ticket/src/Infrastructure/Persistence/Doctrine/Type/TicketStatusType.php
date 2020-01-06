<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Ticket\Domain\Ticket\TicketStatus;

class TicketStatusType extends StringType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        $value = parent::convertToDatabaseValue($value, $platform);
        return (string)$value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $value = parent::convertToPHPValue($value, $platform);

        switch ($value) {
            case 'open':
                $ticketStatus = TicketStatus::open();
                break;

            case 'closed':
                $ticketStatus = TicketStatus::closed();
                break;

            case 'resolved':
                $ticketStatus = TicketStatus::resolved();
                break;

            default:
                throw new \RuntimeException('Cannot parse ticket status to value object.');
        }

        return $ticketStatus;
    }

    public function getName()
    {
        return TicketStatus::class;
    }
}