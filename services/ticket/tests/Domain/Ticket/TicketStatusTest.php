<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Ticket;

use PHPUnit\Framework\TestCase;
use Ticket\Domain\Ticket\TicketStatus;

class TicketStatusTest extends TestCase
{
    public function testEquals_CompareOpenStatusWithAnotherStatuses_EqualsReturnedExpectedResults(): void
    {
        // arrange
        $openStatus = TicketStatus::open();

        // act
        $isEqualToOpen = $openStatus->equals(TicketStatus::open());
        $isEqualToResolved = $openStatus->equals(TicketStatus::resolved());
        $isEqualToClosed = $openStatus->equals(TicketStatus::closed());

        // assert
        $this->assertTrue($isEqualToOpen);
        $this->assertFalse($isEqualToResolved);
        $this->assertFalse($isEqualToClosed);
    }

    public function testEquals_CompareResolvedStatusWithAnotherStatuses_EqualsReturnedExpectedResults(): void
    {
        // arrange
        $resolvedStatus = TicketStatus::resolved();

        // act
        $isEqualToOpen = $resolvedStatus->equals(TicketStatus::open());
        $isEqualToResolved = $resolvedStatus->equals(TicketStatus::resolved());
        $isEqualToClosed = $resolvedStatus->equals(TicketStatus::closed());

        // assert
        $this->assertFalse($isEqualToOpen);
        $this->assertTrue($isEqualToResolved);
        $this->assertFalse($isEqualToClosed);
    }

    public function testEquals_CompareClosedStatusWithAnotherStatuses_EqualsReturnedExpectedResults(): void
    {
        // arrange
        $closedStatus = TicketStatus::closed();

        // act
        $isEqualToOpen = $closedStatus->equals(TicketStatus::open());
        $isEqualToResolved = $closedStatus->equals(TicketStatus::resolved());
        $isEqualToClosed = $closedStatus->equals(TicketStatus::closed());

        // assert
        $this->assertFalse($isEqualToOpen);
        $this->assertFalse($isEqualToResolved);
        $this->assertTrue($isEqualToClosed);
    }

    public function testCreation_WantToCreateOpenStatusViaStaticMethod_CreatedStatusHasExpectedValue(): void
    {
        // act
        $status = TicketStatus::open();
        $statusAsString = (string)$status;

        // assert
        $expectedTicketStatusAsString = 'open';
        $this->assertSame($expectedTicketStatusAsString, $statusAsString);
    }

    public function testCreation_WantToCreateClosedStatusViaStaticMethod_CreatedStatusHasExpectedValue(): void
    {
        // act
        $status = TicketStatus::closed();
        $statusAsString = (string)$status;

        // assert
        $expectedTicketStatusAsString = 'closed';
        $this->assertSame($expectedTicketStatusAsString, $statusAsString);
    }

    public function testCreation_WantToCreateResolvedStatusViaStaticMethod_CreatedStatusHasExpectedValue(): void
    {
        // act
        $status = TicketStatus::resolved();
        $statusAsString = (string)$status;

        // assert
        $expectedTicketStatusAsString = 'resolved';
        $this->assertSame($expectedTicketStatusAsString, $statusAsString);
    }
}