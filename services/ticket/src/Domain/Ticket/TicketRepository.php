<?php
declare(strict_types=1);

namespace Ticket\Domain\Ticket;

interface TicketRepository
{
    public function nextIdentity(): TicketId;
    public function add(Ticket $ticket): void;
    public function getById(TicketId $id): Ticket;
}