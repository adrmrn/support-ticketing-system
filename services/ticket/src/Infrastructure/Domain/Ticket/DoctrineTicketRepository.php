<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Domain\Ticket;

use Ticket\Domain\Exception\TicketNotFound;
use Ticket\Domain\Ticket\Ticket;
use Ticket\Domain\Ticket\TicketId;
use Ticket\Domain\Ticket\TicketRepository;

class DoctrineTicketRepository implements TicketRepository
{

    public function nextIdentity(): TicketId
    {
        // TODO: Implement nextIdentity() method.
    }

    public function add(Ticket $ticket): void
    {
        // TODO: Implement add() method.
    }

    /**
     * @inheritDoc
     */
    public function getById(TicketId $id): Ticket
    {
        // TODO: Implement getById() method.
    }
}