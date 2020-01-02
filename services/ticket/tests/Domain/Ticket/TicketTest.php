<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Ticket;

use PHPUnit\Framework\TestCase;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketMother;

class TicketTest extends TestCase
{
    public function testClose_TicketHasResolvedStatusAndCannotBeChangedToClosed_ThrownException(): void
    {
        // arrange
        $ticket = TicketMother::createResolved();

        // assert
        $this->expectException(\InvalidArgumentException::class);

        // act
        $ticket->close();
    }
}