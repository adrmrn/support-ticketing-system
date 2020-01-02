<?php
declare(strict_types=1);

namespace Ticket\Domain\Ticket;

final class TicketStatus
{
    private const OPEN = 'open';
    private const RESOLVED = 'resolved';
    private const CLOSED = 'closed';

    private string $status;

    private function __construct(string $status)
    {
        $this->status = $status;
    }

    public static function open(): TicketStatus
    {
        return new self(self::OPEN);
    }

    public static function resolved(): TicketStatus
    {
        return new self(self::RESOLVED);
    }

    public static function closed(): TicketStatus
    {
        return new self(self::CLOSED);
    }

    public function equals(TicketStatus $status): bool
    {
        return $this->status === $status->status;
    }

    public function __toString(): string
    {
        return $this->status;
    }
}