<?php
declare(strict_types=1);

namespace Ticket\Domain\Exception;

use Throwable;
use Ticket\Domain\Ticket\TicketId;

final class LockedTicketCannotBeChanged extends \LogicException
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function withTicketId(TicketId $ticketId): LockedTicketCannotBeChanged
    {
        return new self(
            sprintf('Locked ticket cannot be changed. Ticket ID: %s', (string)$ticketId)
        );
    }
}