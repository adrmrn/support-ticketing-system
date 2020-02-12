<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Comment\Event;

use Ticket\Tests\Support\TestCase;
use Ticket\Tests\Support\Helpers\Shared\Domain\FakeCalendar;
use Ticket\Tests\Support\MotherObject\DateTimeMother;
use Ticket\Tests\Support\MotherObject\Domain\Comment\CommentContentMother;
use Ticket\Tests\Support\MotherObject\Domain\Comment\CommentIdMother;
use Ticket\Tests\Support\MotherObject\Domain\Comment\Event\CommentCreatedMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketIdMother;
use Ticket\Tests\Support\MotherObject\Domain\User\UserIdMother;

class CommentCreatedTest extends TestCase
{
    public function testAggregateId_HaveSpecificCategoryIdentifier_ExpectedAggregateIdReturned(): void
    {
        // arrange
        $expectedAggregateId = 'ID-COMMENT-0';

        // act
        $commentCreated = CommentCreatedMother::createWithParams([
            'id' => CommentIdMother::create($expectedAggregateId)
        ]);
        $aggregateId = $commentCreated->aggregateId();

        // assert
        $this->assertEquals($expectedAggregateId, $aggregateId);
    }

    public function testOccurredOn_HaveOccurredOnDateAsDefault_ExpectedOccurredOnReturned(): void
    {
        // arrange
        $occurredOnAsString = '2020-01-01 14:45:45';
        FakeCalendar::setFakeDate($occurredOnAsString);

        // act
        $commentCreated = CommentCreatedMother::createDefault();
        $occurredOn = $commentCreated->occurredOn();

        // assert
        $expectedOccurredOn = new \DateTimeImmutable($occurredOnAsString);
        $this->assertEquals($expectedOccurredOn, $occurredOn);
    }

    public function testVersion_HaveVersionAsDefault_ExpectedVersionOfEventReturned(): void
    {
        // act
        $commentCreated = CommentCreatedMother::createDefault();
        $version = $commentCreated->version();

        // assert
        $expectedVersion = 0;
        $this->assertEquals($expectedVersion, $version);
    }

    public function testData_HaveCommentCreatedEventWithSpecificData_ExpectedDataAsArrayReturned(): void
    {
        // arrange
        $id = 'ID-COMMENT-0';
        $content = 'Comment content';
        $authorId = 'ID-USER-0';
        $ticketId = 'ID-TICKET-0';
        $createdAt = '2020-01-01 10:00:50';

        // act
        $commentCreated = CommentCreatedMother::createWithParams([
            'id' => CommentIdMother::create($id),
            'content' => CommentContentMother::create($content),
            'author_id' => UserIdMother::create($authorId),
            'ticket_id' => TicketIdMother::create($ticketId),
            'created_at' => DateTimeMother::create($createdAt)
        ]);
        $data = $commentCreated->data();

        // assert
        $expectedData = [
            'id' => 'ID-COMMENT-0',
            'content' => 'Comment content',
            'authorId' => 'ID-USER-0',
            'ticketId' => 'ID-TICKET-0',
            'createdAt' => '2020-01-01 10:00:50'
        ];
        $this->assertEquals($expectedData, $data);
    }

    public function testDataAsJson_HaveCommentCreatedEventWithSpecificData_ExpectedDataAsJsonReturned(): void
    {
        // arrange
        $id = 'ID-COMMENT-0';
        $content = 'Comment content';
        $authorId = 'ID-USER-0';
        $ticketId = 'ID-TICKET-0';
        $createdAt = '2020-01-01 10:00:50';

        // act
        $commentCreated = CommentCreatedMother::createWithParams([
            'id' => CommentIdMother::create($id),
            'content' => CommentContentMother::create($content),
            'author_id' => UserIdMother::create($authorId),
            'ticket_id' => TicketIdMother::create($ticketId),
            'created_at' => DateTimeMother::create($createdAt)
        ]);
        $dataAsJson = $commentCreated->dataAsJson();

        // assert
        $expectedDataAsJson = '{
            "id": "ID-COMMENT-0",
            "content": "Comment content",
            "authorId": "ID-USER-0",
            "ticketId": "ID-TICKET-0",
            "createdAt": "2020-01-01 10:00:50"
        }';
        $this->assertJsonStringEqualsJsonString($expectedDataAsJson, $dataAsJson);
    }
}