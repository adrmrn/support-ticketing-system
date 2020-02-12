<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Exception;

use Ticket\Domain\DomainException;
use Ticket\Domain\Exception\TicketNotFound;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketIdMother;
use Ticket\Tests\Support\TestCase;

class TicketNotFoundTest extends TestCase
{
    public function testCreation_HaveTicketIdThatDoesNotExist_ReturnedExceptionHasExpectedValues(): void
    {
        // arrange
        $expectedTicketIdAsString = 'ID-TICKET-0';
        $ticketId = TicketIdMother::create($expectedTicketIdAsString);

        // act
        $exception = TicketNotFound::withTicketId($ticketId);

        // assert
        $this->assertInstanceOf(DomainException::class, $exception);
        $this->assertInstanceOf(TicketNotFound::class, $exception);
        $expectedMessage = sprintf('Ticket not found. Ticket ID: %s', $expectedTicketIdAsString);
        $this->assertSame($expectedMessage, $exception->getMessage());
    }
}