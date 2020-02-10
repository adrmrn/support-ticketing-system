<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Ticket\Event;

use PHPUnit\Framework\TestCase;
use Ticket\Tests\Support\Helpers\Shared\Domain\FakeCalendar;
use Ticket\Tests\Support\MotherObject\Domain\Category\CategoryIdMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\Event\TicketCreatedMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketDescriptionMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketIdMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketTitleMother;
use Ticket\Tests\Support\MotherObject\Domain\User\UserIdMother;

class TicketCreatedTest extends TestCase
{
    public function testAggregateId_HaveSpecificCategoryIdentifier_ExpectedAggregateIdReturned(): void
    {
        // arrange
        $expectedAggregateId = 'ID-TICKET-0';

        // act
        $categoryCreated = TicketCreatedMother::createWithParams([
            'id' => TicketIdMother::create($expectedAggregateId)
        ]);
        $aggregateId = $categoryCreated->aggregateId();

        // assert
        $this->assertEquals($expectedAggregateId, $aggregateId);
    }

    public function testOccurredOn_HaveOccurredOnDateAsDefault_ExpectedOccurredOnReturned(): void
    {
        // arrange
        $occurredOnAsString = '2020-01-01 14:45:45';
        FakeCalendar::setFakeDate($occurredOnAsString);

        // act
        $ticketCreated = TicketCreatedMother::createDefault();
        $occurredOn = $ticketCreated->occurredOn();

        // assert
        $expectedOccurredOn = new \DateTimeImmutable($occurredOnAsString);
        $this->assertEquals($expectedOccurredOn, $occurredOn);
    }

    public function testVersion_HaveVersionAsDefault_ExpectedVersionOfEventReturned(): void
    {
        // act
        $categoryCreated = TicketCreatedMother::createDefault();
        $version = $categoryCreated->version();

        // assert
        $expectedVersion = 0;
        $this->assertEquals($expectedVersion, $version);
    }

    public function testData_HaveTicketCreatedEventWithSpecificData_ExpectedDataAsArrayReturned(): void
    {
        // arrange
        $id = 'ID-TICKET-0';
        $title = 'Ticket example title';
        $description = 'Ticket example description';
        $categoryId = 'ID-CATEGORY-0';
        $authorId = 'ID-USER-0';

        // act
        $ticketCreated = TicketCreatedMother::createWithParams([
            'id' => TicketIdMother::create($id),
            'title' => TicketTitleMother::create($title),
            'description' => TicketDescriptionMother::create($description),
            'category_id' => CategoryIdMother::create($categoryId),
            'author_id' => UserIdMother::create($authorId)
        ]);
        $data = $ticketCreated->data();

        // assert
        $expectedData = [
            'id' => 'ID-TICKET-0',
            'title' => 'Ticket example title',
            'description' => 'Ticket example description',
            'categoryId' => 'ID-CATEGORY-0',
            'authorId' => 'ID-USER-0'
        ];
        $this->assertEquals($expectedData, $data);
    }

    public function testDataAsJson_HaveTicketCreatedEventWithSpecificData_ExpectedDataAsJsonReturned(): void
    {
        // arrange
        $id = 'ID-TICKET-0';
        $title = 'Ticket example title';
        $description = 'Ticket example description';
        $categoryId = 'ID-CATEGORY-0';
        $authorId = 'ID-USER-0';

        // act
        $ticketCreated = TicketCreatedMother::createWithParams([
            'id' => TicketIdMother::create($id),
            'title' => TicketTitleMother::create($title),
            'description' => TicketDescriptionMother::create($description),
            'category_id' => CategoryIdMother::create($categoryId),
            'author_id' => UserIdMother::create($authorId)
        ]);
        $dataAsJson = $ticketCreated->dataAsJson();

        // assert
        $expectedDataAsJson = '{
            "id": "ID-TICKET-0",
            "title": "Ticket example title",
            "description": "Ticket example description",
            "categoryId": "ID-CATEGORY-0",
            "authorId": "ID-USER-0"
        }';
        $this->assertJsonStringEqualsJsonString($expectedDataAsJson, $dataAsJson);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        FakeCalendar::destroy();
    }
}