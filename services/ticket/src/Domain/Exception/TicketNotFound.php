<?php
declare(strict_types=1);

namespace Ticket\Domain\Exception;

use Ticket\Domain\NotFoundException;
use Ticket\Domain\Ticket\TicketId;

final class TicketNotFound extends NotFoundException
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function withTicketId(TicketId $ticketId): TicketNotFound
    {
        return new self(
            sprintf('Ticket not found. Ticket ID: %s', (string)$ticketId)
        );
    }
}