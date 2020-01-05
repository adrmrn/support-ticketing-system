<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\Ticket;

use Ticket\Domain\Ticket\TicketDescription;

final class TicketDescriptionMother
{
    public static function createDefault(): TicketDescription
    {
        return new TicketDescription('Example ticket description');
    }

    public static function create(string $description): TicketDescription
    {
        return new TicketDescription($description);
    }
}