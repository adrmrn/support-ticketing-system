<?php
declare(strict_types=1);

namespace Ticket\Domain\Exception;

use Ticket\Domain\NotFoundException;

class TicketViewNotFound extends NotFoundException
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function withTicketId(string $ticketId): TicketViewNotFound
    {
        return new self(
            sprintf('Ticket not found. Ticket ID: %s', $ticketId)
        );
    }
}