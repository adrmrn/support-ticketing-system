<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Event;

use Ticket\Domain\DomainException;
use Ticket\Domain\Exception\ResolvedTicketCannotBeClosed;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketIdMother;
use Ticket\Tests\Support\TestCase;

class ResolvedTicketCannotBeClosedTest extends TestCase
{
    public function testCreation_HaveTicketIdThatIsResolved_ReturnedExceptionHasExpectedValues(): void
    {
        // arrange
        $expectedTicketIdAsString = 'ID-TICKET-0';
        $ticketId = TicketIdMother::create($expectedTicketIdAsString);

        // act
        $exception = ResolvedTicketCannotBeClosed::withTicketId($ticketId);

        // assert
        $this->assertInstanceOf(DomainException::class, $exception);
        $this->assertInstanceOf(ResolvedTicketCannotBeClosed::class, $exception);
        $expectedMessage = sprintf('Resolved ticket cannot be closed. Ticket ID: %s', $expectedTicketIdAsString);
        $this->assertSame($expectedMessage, $exception->getMessage());
    }
}