<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Exception;

use Ticket\Domain\DomainException;
use Ticket\Domain\Exception\LockedTicketCannotBeChanged;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketIdMother;
use Ticket\Tests\Support\TestCase;

class LockedTicketCannotBeChangedTest extends TestCase
{
    public function testCreation_HaveTicketIdThatIsLocked_ReturnedExceptionHasExpectedValues(): void
    {
        // arrange
        $expectedTicketIdAsString = 'ID-TICKET-0';
        $ticketId = TicketIdMother::create($expectedTicketIdAsString);

        // act
        $exception = LockedTicketCannotBeChanged::withTicketId($ticketId);

        // assert
        $this->assertInstanceOf(DomainException::class, $exception);
        $this->assertInstanceOf(LockedTicketCannotBeChanged::class, $exception);
        $expectedMessage = sprintf('Locked ticket cannot be changed. Ticket ID: %s', $expectedTicketIdAsString);
        $this->assertSame($expectedMessage, $exception->getMessage());
    }
}