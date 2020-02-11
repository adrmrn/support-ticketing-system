<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Comment\Event;

use PHPUnit\Framework\TestCase;
use Ticket\Tests\Support\Helpers\Shared\Domain\FakeCalendar;
use Ticket\Tests\Support\MotherObject\Domain\Comment\CommentIdMother;
use Ticket\Tests\Support\MotherObject\Domain\Comment\Event\CommentRemovedMother;

class CommentRemovedTest extends TestCase
{
    public function testAggregateId_HaveSpecificCategoryIdentifier_ExpectedAggregateIdReturned(): void
    {
        // arrange
        $expectedAggregateId = 'ID-COMMENT-0';

        // act
        $commentRemoved = CommentRemovedMother::create(
            CommentIdMother::create($expectedAggregateId)
        );
        $aggregateId = $commentRemoved->aggregateId();

        // assert
        $this->assertEquals($expectedAggregateId, $aggregateId);
    }

    public function testOccurredOn_HaveOccurredOnDateAsDefault_ExpectedOccurredOnReturned(): void
    {
        // arrange
        $occurredOnAsString = '2020-01-01 14:45:45';
        FakeCalendar::setFakeDate($occurredOnAsString);

        // act
        $commentRemoved = CommentRemovedMother::createDefault();
        $occurredOn = $commentRemoved->occurredOn();

        // assert
        $expectedOccurredOn = new \DateTimeImmutable($occurredOnAsString);
        $this->assertEquals($expectedOccurredOn, $occurredOn);
    }

    public function testVersion_HaveVersionAsDefault_ExpectedVersionOfEventReturned(): void
    {
        // act
        $commentRemoved = CommentRemovedMother::createDefault();
        $version = $commentRemoved->version();

        // assert
        $expectedVersion = 0;
        $this->assertEquals($expectedVersion, $version);
    }

    public function testData_HaveCommentRemovedEventWithSpecificData_ExpectedDataAsArrayReturned(): void
    {
        // arrange
        $id = 'ID-COMMENT-0';

        // act
        $commentRemoved = CommentRemovedMother::create(
            CommentIdMother::create($id)
        );
        $data = $commentRemoved->data();

        // assert
        $expectedData = [
            'id' => 'ID-COMMENT-0'
        ];
        $this->assertEquals($expectedData, $data);
    }

    public function testDataAsJson_HaveCommentRemovedEventWithSpecificData_ExpectedDataAsJsonReturned(): void
    {
        // arrange
        $id = 'ID-COMMENT-0';

        // act
        $commentRemoved = CommentRemovedMother::create(
            CommentIdMother::create($id)
        );
        $dataAsJson = $commentRemoved->dataAsJson();

        // assert
        $expectedDataAsJson = '{
            "id": "ID-COMMENT-0"
        }';
        $this->assertJsonStringEqualsJsonString($expectedDataAsJson, $dataAsJson);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        FakeCalendar::destroy();
    }
}