<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Comment\Event;

use PHPUnit\Framework\TestCase;
use Ticket\Tests\Support\Helpers\Shared\Domain\FakeCalendar;
use Ticket\Tests\Support\MotherObject\Domain\Comment\CommentContentMother;
use Ticket\Tests\Support\MotherObject\Domain\Comment\CommentIdMother;
use Ticket\Tests\Support\MotherObject\Domain\Comment\Event\CommentContentEditedMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketIdMother;

class CommentContentEditedTest extends TestCase
{
    public function testAggregateId_HaveSpecificCategoryIdentifier_ExpectedAggregateIdReturned(): void
    {
        // arrange
        $expectedAggregateId = 'ID-COMMENT-0';

        // act
        $commentContentEdited = CommentContentEditedMother::createWithParams([
            'id' => CommentIdMother::create($expectedAggregateId)
        ]);
        $aggregateId = $commentContentEdited->aggregateId();

        // assert
        $this->assertEquals($expectedAggregateId, $aggregateId);
    }

    public function testOccurredOn_HaveOccurredOnDateAsDefault_ExpectedOccurredOnReturned(): void
    {
        // arrange
        $occurredOnAsString = '2020-01-01 14:45:45';
        FakeCalendar::setFakeDate($occurredOnAsString);

        // act
        $commentContentEdited = CommentContentEditedMother::createDefault();
        $occurredOn = $commentContentEdited->occurredOn();

        // assert
        $expectedOccurredOn = new \DateTimeImmutable($occurredOnAsString);
        $this->assertEquals($expectedOccurredOn, $occurredOn);
    }

    public function testVersion_HaveVersionAsDefault_ExpectedVersionOfEventReturned(): void
    {
        // act
        $commentContentEdited = CommentContentEditedMother::createDefault();
        $version = $commentContentEdited->version();

        // assert
        $expectedVersion = 0;
        $this->assertEquals($expectedVersion, $version);
    }

    public function testData_HaveCommentContentEditedEventWithSpecificData_ExpectedDataAsArrayReturned(): void
    {
        // arrange
        $id = 'ID-COMMENT-0';
        $content = 'Comment content';

        // act
        $commentContentEdited = CommentContentEditedMother::createWithParams([
            'id' => CommentIdMother::create($id),
            'content' => CommentContentMother::create($content)
        ]);
        $data = $commentContentEdited->data();

        // assert
        $expectedData = [
            'id' => 'ID-COMMENT-0',
            'content' => 'Comment content'
        ];
        $this->assertEquals($expectedData, $data);
    }

    public function testDataAsJson_HaveCommentContentEditedEventWithSpecificData_ExpectedDataAsJsonReturned(): void
    {
        // arrange
        $id = 'ID-COMMENT-0';
        $content = 'Comment content';

        // act
        $commentContentEdited = CommentContentEditedMother::createWithParams([
            'id' => CommentIdMother::create($id),
            'content' => CommentContentMother::create($content)
        ]);
        $dataAsJson = $commentContentEdited->dataAsJson();

        // assert
        $expectedDataAsJson = '{
            "id": "ID-COMMENT-0",
            "content": "Comment content"
        }';
        $this->assertJsonStringEqualsJsonString($expectedDataAsJson, $dataAsJson);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        FakeCalendar::destroy();
    }
}