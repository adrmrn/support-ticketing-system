<?php
declare(strict_types=1);

namespace Ticket\Domain\Exception;

use Ticket\Domain\DomainException;
use Ticket\Domain\Ticket\TicketId;

final class ResolvedTicketCannotBeClosed extends DomainException
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function withTicketId(TicketId $ticketId): ResolvedTicketCannotBeClosed
    {
        return new self(
            sprintf('Resolved ticket cannot be closed. Ticket ID: %s', (string)$ticketId)
        );
    }
}