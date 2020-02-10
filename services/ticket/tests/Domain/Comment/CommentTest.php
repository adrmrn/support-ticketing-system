<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Comment;

use PHPUnit\Framework\TestCase;
use Ticket\Domain\Comment\Comment;
use Ticket\Domain\Comment\Event\CommentContentEdited;
use Ticket\Domain\Event\DomainEvent;
use Ticket\Tests\Support\Helpers\Shared\Domain\FakeCalendar;
use Ticket\Tests\Support\MotherObject\DateTimeMother;
use Ticket\Tests\Support\MotherObject\Domain\Comment\CommentContentMother;
use Ticket\Tests\Support\MotherObject\Domain\Comment\CommentIdMother;
use Ticket\Tests\Support\MotherObject\Domain\Comment\CommentMother;
use Ticket\Tests\Support\MotherObject\Domain\Comment\Event\CommentContentEditedMother;
use Ticket\Tests\Support\MotherObject\Domain\Comment\Event\CommentCreatedMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketIdMother;
use Ticket\Tests\Support\MotherObject\Domain\User\UserIdMother;

class CommentTest extends TestCase
{
    public function testCreation_HaveAllRequiredValues_CreatedCommentHasExpectedValues(): void
    {
        // arrange
        $expectedId = CommentIdMother::createDefault();
        $expectedContent = CommentContentMother::createDefault();
        $expectedAuthorId = UserIdMother::createDefault();
        $expectedTicketId = TicketIdMother::createDefault();
        FakeCalendar::setFakeDate('2020-01-01 10:00:10');

        // act
        $comment = CommentMother::create(
            $expectedId,
            $expectedContent,
            $expectedAuthorId,
            $expectedTicketId
        );

        // assert
        $this->assertEquals($expectedId, $comment->id());
        $this->assertEquals($expectedContent, $comment->content());
        $this->assertEquals($expectedAuthorId, $comment->authorId());
        $this->assertEquals($expectedTicketId, $comment->ticketId());
        $expectedCreatedAt = new \DateTimeImmutable('2020-01-01 10:00:10');
        $this->assertEquals($expectedCreatedAt, $comment->createdAt());
    }

    public function testCreation_HaveAllRequiredValues_CommentCreatedEventRaised(): void
    {
        // arrange
        $id = CommentIdMother::createDefault();
        $content = CommentContentMother::createDefault();
        $authorId = UserIdMother::createDefault();
        $ticketId = TicketIdMother::createDefault();
        $createdAtAsString = '2020-01-01 10:00:10';
        $createdAt = DateTimeMother::create($createdAtAsString);
        FakeCalendar::setFakeDate($createdAtAsString);

        // act
        $comment = CommentMother::create(
            $id,
            $content,
            $authorId,
            $ticketId
        );

        // assert
        $expectedRaisedEvent = CommentCreatedMother::create($id, $content, $authorId, $ticketId, $createdAt);
        $this->assertEventRaised($expectedRaisedEvent, $comment);
    }

    public function testEdit_HaveNewContent_ContentHasBeenEdited(): void
    {
        // arrange
        $oldContent = CommentContentMother::create('Old comment content');
        $comment = CommentMother::createWithParams([
            'content' => $oldContent
        ]);
        $expectedNewContent = CommentContentMother::create('New comment content');

        // act
        $comment->edit($expectedNewContent);

        // assert
        $this->assertEquals($expectedNewContent, $comment->content());
    }

    public function testEdit_HaveSameOldAndNewContent_CommentContentEditedEventNotRaised(): void
    {
        // arrange
        $oldContent = CommentContentMother::create('Old content');
        $comment = CommentMother::createWithParams([
            'content' => $oldContent
        ]);
        $newContent = CommentContentMother::create('Old content');

        // act
        $comment->edit($newContent);

        // assert
        $this->assertEventNotRaised(CommentContentEdited::class, $comment);
    }

    public function testEdit_HaveNewContent_CommentContentChangedEventRaised(): void
    {
        // arrange
        $id = CommentIdMother::createDefault();
        $oldContent = CommentContentMother::create('Old content');
        $comment = CommentMother::createWithParams([
            'id' => $id,
            'content' => $oldContent
        ]);
        $newContent = CommentContentMother::create('New content');
        $occurredOnAsString = '2020-01-01 10:00:06';
        FakeCalendar::setFakeDate($occurredOnAsString);

        // act
        $comment->edit($newContent);

        // assert
        $expectedRaisedEvent = CommentContentEditedMother::create($id, $newContent);
        $this->assertEventRaised($expectedRaisedEvent, $comment);
    }

    private function assertEventRaised(DomainEvent $expectedEvent, Comment $comment): void
    {
        $eventRaised = false;
        foreach ($comment->popRaisedEvents() as $raisedEvent) {
            if ($expectedEvent == $raisedEvent) {
                $eventRaised = true;
                break;
            }
        }

        $this->assertTrue($eventRaised);
    }

    private function assertEventNotRaised(string $eventClass, Comment $comment): void
    {
        $eventRaised = false;
        foreach ($comment->popRaisedEvents() as $raisedEvent) {
            if (get_class($raisedEvent) === $eventClass) {
                $eventRaised = true;
                break;
            }
        }

        $this->assertFalse($eventRaised);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        FakeCalendar::destroy();
    }
}