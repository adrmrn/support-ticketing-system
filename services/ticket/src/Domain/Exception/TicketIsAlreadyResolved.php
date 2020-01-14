<?php
declare(strict_types=1);

namespace Ticket\Domain\Exception;

use Ticket\Domain\Ticket\TicketId;

final class TicketIsAlreadyResolved extends \LogicException
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function withTicketId(TicketId $ticketId): TicketIsAlreadyResolved
    {
        return new self(
            sprintf('Ticket is already resolved. Ticket ID: %s', (string)$ticketId)
        );
    }
}