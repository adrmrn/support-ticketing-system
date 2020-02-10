<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Ticket\Event;

use PHPUnit\Framework\TestCase;
use Ticket\Tests\Support\Helpers\Shared\Domain\FakeCalendar;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\Event\TicketTitleChangedMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketIdMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketTitleMother;

class TicketTitleChangedTest extends TestCase
{
    public function testAggregateId_HaveSpecificCategoryIdentifier_ExpectedAggregateIdReturned(): void
    {
        // arrange
        $expectedAggregateId = 'ID-TICKET-0';

        // act
        $ticketTitleChanged = TicketTitleChangedMother::createWithParams([
            'id' => TicketIdMother::create($expectedAggregateId)
        ]);
        $aggregateId = $ticketTitleChanged->aggregateId();

        // assert
        $this->assertEquals($expectedAggregateId, $aggregateId);
    }

    public function testOccurredOn_HaveOccurredOnDateAsDefault_ExpectedOccurredOnReturned(): void
    {
        // arrange
        $occurredOnAsString = '2020-01-01 14:45:45';
        FakeCalendar::setFakeDate($occurredOnAsString);

        // act
        $ticketTitleChanged = TicketTitleChangedMother::createDefault();
        $occurredOn = $ticketTitleChanged->occurredOn();

        // assert
        $expectedOccurredOn = new \DateTimeImmutable($occurredOnAsString);
        $this->assertEquals($expectedOccurredOn, $occurredOn);
    }

    public function testVersion_HaveVersionAsDefault_ExpectedVersionOfEventReturned(): void
    {
        // act
        $ticketTitleChanged = TicketTitleChangedMother::createDefault();
        $version = $ticketTitleChanged->version();

        // assert
        $expectedVersion = 0;
        $this->assertEquals($expectedVersion, $version);
    }

    public function testData_HaveTicketTitleChangedEventWithSpecificData_ExpectedDataAsArrayReturned(): void
    {
        // arrange
        $id = 'ID-TICKET-0';
        $title = 'Ticket title';

        // act
        $ticketTitleChanged = TicketTitleChangedMother::createWithParams([
            'id' => TicketIdMother::create($id),
            'title' => TicketTitleMother::create($title)
        ]);
        $data = $ticketTitleChanged->data();

        // assert
        $expectedData = [
            'id' => 'ID-TICKET-0',
            'title' => 'Ticket title'
        ];
        $this->assertEquals($expectedData, $data);
    }

    public function testDataAsJson_HaveTicketTitleChangedEventWithSpecificData_ExpectedDataAsJsonReturned(): void
    {
        // arrange
        $id = 'ID-TICKET-0';
        $title = 'Ticket title';

        // act
        $ticketTitleChanged = TicketTitleChangedMother::createWithParams([
            'id' => TicketIdMother::create($id),
            'title' => TicketTitleMother::create($title)
        ]);
        $dataAsJson = $ticketTitleChanged->dataAsJson();

        // assert
        $expectedDataAsJson = '{
            "id": "ID-TICKET-0",
            "title": "Ticket title"
        }';
        $this->assertJsonStringEqualsJsonString($expectedDataAsJson, $dataAsJson);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        FakeCalendar::destroy();
    }
}