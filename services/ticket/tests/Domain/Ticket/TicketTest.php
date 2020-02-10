<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Ticket;

use PHPUnit\Framework\TestCase;
use Ticket\Domain\Event\DomainEvent;
use Ticket\Domain\Exception\LockedTicketCannotBeChanged;
use Ticket\Domain\Exception\ResolvedTicketCannotBeClosed;
use Ticket\Domain\Ticket\Event\TicketCategoryChanged;
use Ticket\Domain\Ticket\Event\TicketClosed;
use Ticket\Domain\Ticket\Event\TicketDescribed;
use Ticket\Domain\Ticket\Event\TicketResolved;
use Ticket\Domain\Ticket\Event\TicketTitleChanged;
use Ticket\Domain\Ticket\Ticket;
use Ticket\Domain\Ticket\TicketStatus;
use Ticket\Tests\Support\Helpers\Shared\Domain\FakeCalendar;
use Ticket\Tests\Support\MotherObject\DateTimeMother;
use Ticket\Tests\Support\MotherObject\Domain\Category\CategoryIdMother;
use Ticket\Tests\Support\MotherObject\Domain\Comment\CommentContentMother;
use Ticket\Tests\Support\MotherObject\Domain\Comment\CommentIdMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\Event\TicketCategoryChangedMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\Event\TicketClosedMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\Event\TicketCreatedMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\Event\TicketDescribedMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\Event\TicketResolvedMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\Event\TicketTitleChangedMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketDescriptionMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketIdMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketTitleMother;
use Ticket\Tests\Support\MotherObject\Domain\User\UserIdMother;

class TicketTest extends TestCase
{
    public function testCreation_HaveAllRequiredValues_CreatedTicketHasExpectedValues(): void
    {
        // arrange
        $expectedId = TicketIdMother::createDefault();
        $expectedTitle = TicketTitleMother::createDefault();
        $expectedDescription = TicketDescriptionMother::createDefault();
        $expectedCategoryId = CategoryIdMother::createDefault();
        $expectedAuthorId = UserIdMother::createDefault();
        $createdAtAsString = '2020-01-01 10:00:01';
        FakeCalendar::setFakeDate($createdAtAsString);

        // act
        $ticket = TicketMother::create(
            $expectedId,
            $expectedTitle,
            $expectedDescription,
            $expectedCategoryId,
            $expectedAuthorId
        );

        // assert
        $this->assertEquals($expectedId, $ticket->id());
        $this->assertEquals($expectedTitle, $ticket->title());
        $this->assertEquals($expectedDescription, $ticket->description());
        $this->assertEquals($expectedCategoryId, $ticket->categoryId());
        $this->assertEquals($expectedAuthorId, $ticket->authorId());
        $expectedStatus = TicketStatus::open();
        $this->assertEquals($expectedStatus, $ticket->status());
        $expectedCreatedAt = DateTimeMother::create($createdAtAsString);
        $this->assertEquals($expectedCreatedAt, $ticket->createdAt());
    }

    public function testCreation_HaveAllRequiredValues_TicketCreatedEventRaised(): void
    {
        // arrange
        $id = TicketIdMother::createDefault();
        $title = TicketTitleMother::createDefault();
        $description = TicketDescriptionMother::createDefault();
        $categoryId = CategoryIdMother::createDefault();
        $authorId = UserIdMother::createDefault();
        $createdAtAsString = '2020-01-01 10:00:01';
        FakeCalendar::setFakeDate($createdAtAsString);

        // act
        $ticket = TicketMother::create(
            $id,
            $title,
            $description,
            $categoryId,
            $authorId
        );

        // assert
        $expectedRaisedEvent = TicketCreatedMother::create($id, $title, $description, $categoryId, $authorId);
        $this->assertEventRaised($expectedRaisedEvent, $ticket);
    }

    public function testClose_TicketHasResolvedStatusAndCannotBeChangedToClosed_ThrownException(): void
    {
        // arrange
        $ticket = TicketMother::createResolved();

        // assert
        $this->expectException(ResolvedTicketCannotBeClosed::class);

        // act
        $ticket->close();
    }

    public function testClose_TicketHasOpenStatusAndCanBeChanged_StatusChangedSuccessfully(): void
    {
        // arrange
        $ticket = TicketMother::createDefault();

        // act
        $ticket->close();
        $status = $ticket->status();

        // assert
        $expectedStatus = TicketStatus::closed();
        $this->assertEquals($expectedStatus, $status);
    }

    public function testClose_HaveAlreadyClosedTicket_TicketClosedEventNotRaised(): void
    {
        // arrange
        $ticket = TicketMother::createClosed();
        $ticket->popRaisedEvents(); // clear raised events

        // act
        $ticket->close();

        // assert
        $this->assertEventNotRaised(TicketClosed::class, $ticket);
    }

    public function testClose_HaveOpenTicket_TicketClosedEventRaised(): void
    {
        // arrange
        $id = TicketIdMother::createDefault();
        $ticket = TicketMother::createWithParams([
            'id' => $id
        ]);
        $occurredOnAsString = '2020-01-01 10:00:06';
        FakeCalendar::setFakeDate($occurredOnAsString);

        // act
        $ticket->close();

        // assert
        $expectedRaisedEvent = TicketClosedMother::create($id);
        $this->assertEventRaised($expectedRaisedEvent, $ticket);
    }

    public function testChangeTitle_TicketIsClosedAndTitleCannotBeChanged_ThrownException(): void
    {
        // arrange
        $ticket = TicketMother::createClosed();
        $newTitle = TicketTitleMother::createDefault();

        // assert
        $this->expectException(LockedTicketCannotBeChanged::class);

        // act
        $ticket->changeTitle($newTitle);
    }

    public function testChangeTitle_TicketIsResolvedAndTitleCannotBeChanged_ThrownException(): void
    {
        // arrange
        $ticket = TicketMother::createResolved();
        $newTitle = TicketTitleMother::createDefault();

        // assert
        $this->expectException(LockedTicketCannotBeChanged::class);

        // act
        $ticket->changeTitle($newTitle);
    }

    public function testChangeTitle_HaveNewTitleAndTicketIsOpen_TitleHasBeenChanged(): void
    {
        // arrange
        $ticket = TicketMother::createDefault();
        $expectedNewTitle = TicketTitleMother::create('Lorem ipsum...');

        // act
        $ticket->changeTitle($expectedNewTitle);
        $newTitle = $ticket->title();

        // assert
        $this->assertEquals($expectedNewTitle, $newTitle);
    }

    public function testChangeTitle_HaveSameOldAndNewTitle_TitleChangedEventNotRaised(): void
    {
        // arrange
        $oldTitle = TicketTitleMother::create('Old title');
        $ticket = TicketMother::createWithParams([
            'title' => $oldTitle
        ]);
        $newTitle = TicketTitleMother::create('Old title');

        // act
        $ticket->changeTitle($newTitle);

        // assert
        $this->assertEventNotRaised(TicketTitleChanged::class, $ticket);
    }

    public function testChangeTitle_HaveNewTitle_TitleChangedEventRaised(): void
    {
        // arrange
        $id = TicketIdMother::createDefault();
        $oldTitle = TicketTitleMother::create('Old title');
        $ticket = TicketMother::createWithParams([
            'id' => $id,
            'title' => $oldTitle
        ]);
        $newTitle = TicketTitleMother::create('New title');
        $occurredOnAsString = '2020-01-01 10:00:06';
        FakeCalendar::setFakeDate($occurredOnAsString);

        // act
        $ticket->changeTitle($newTitle);

        // assert
        $expectedRaisedEvent = TicketTitleChangedMother::create($id, $newTitle);
        $this->assertEventRaised($expectedRaisedEvent, $ticket);
    }

    public function testDescribe_TicketIsClosedAndDescriptionCannotBeChanged_ThrownException(): void
    {
        // arrange
        $ticket = TicketMother::createClosed();
        $newDescription = TicketDescriptionMother::createDefault();

        // assert
        $this->expectException(LockedTicketCannotBeChanged::class);

        // act
        $ticket->describe($newDescription);
    }

    public function testDescribe_TicketIsResolvedAndDescriptionCannotBeChanged_ThrownException(): void
    {
        // arrange
        $ticket = TicketMother::createResolved();
        $newDescription = TicketDescriptionMother::createDefault();

        // assert
        $this->expectException(LockedTicketCannotBeChanged::class);

        // act
        $ticket->describe($newDescription);
    }

    public function testDescribe_HaveNewDescriptionAndTicketIsOpen_DescriptionHasBeenChanged(): void
    {
        // arrange
        $ticket = TicketMother::createDefault();
        $expectedNewDescription = TicketDescriptionMother::create('Lorem ipsum dolor sit amet...');

        // act
        $ticket->describe($expectedNewDescription);
        $newDescription = $ticket->description();

        // assert
        $this->assertEquals($expectedNewDescription, $newDescription);
    }

    public function testDescribe_HaveSameOldAndNewDescription_TicketDescribedEventNotRaised(): void
    {
        // arrange
        $oldDescription = TicketDescriptionMother::create('Old description');
        $ticket = TicketMother::createWithParams([
            'description' => $oldDescription
        ]);
        $newDescription = TicketDescriptionMother::create('Old description');

        // act
        $ticket->describe($newDescription);

        // assert
        $this->assertEventNotRaised(TicketDescribed::class, $ticket);
    }

    public function testDescribe_HaveNewDescription_TicketDescribedEventRaised(): void
    {
        // arrange
        $id = TicketIdMother::createDefault();
        $oldDescription = TicketDescriptionMother::create('Old description');
        $ticket = TicketMother::createWithParams([
            'id' => $id,
            'description' => $oldDescription
        ]);
        $newDescription = TicketDescriptionMother::create('New description');
        $occurredOnAsString = '2020-01-01 10:00:06';
        FakeCalendar::setFakeDate($occurredOnAsString);

        // act
        $ticket->describe($newDescription);

        // assert
        $expectedRaisedEvent = TicketDescribedMother::create($id, $newDescription);
        $this->assertEventRaised($expectedRaisedEvent, $ticket);
    }

    public function testChangeCategory_TicketIsClosedAndCategoryCannotBeChanged_ThrownException(): void
    {
        // arrange
        $ticket = TicketMother::createClosed();
        $newCategory = CategoryIdMother::createDefault();

        // assert
        $this->expectException(LockedTicketCannotBeChanged::class);

        // act
        $ticket->changeCategory($newCategory);
    }

    public function testChangeCategory_TicketIsResolvedAndCategoryCannotBeChanged_ThrownException(): void
    {
        // arrange
        $ticket = TicketMother::createResolved();
        $newCategory = CategoryIdMother::createDefault();

        // assert
        $this->expectException(LockedTicketCannotBeChanged::class);

        // act
        $ticket->changeCategory($newCategory);
    }

    public function testChangeCategory_HaveNewCategoryAndTicketIsOpen_CategoryHasBeenChanged(): void
    {
        // arrange
        $ticket = TicketMother::createDefault();
        $expectedNewCategory = CategoryIdMother::createDefault();

        // act
        $ticket->changeCategory($expectedNewCategory);
        $newCategory = $ticket->categoryId();

        // assert
        $this->assertEquals($expectedNewCategory, $newCategory);
    }

    public function testChangeCategory_HaveSameOldAndNewCategory_TicketCategoryChangedEventNotRaised(): void
    {
        // arrange
        $oldCategoryId = CategoryIdMother::create('ID-CATEGORY-0');
        $ticket = TicketMother::createWithParams([
            'category_id' => $oldCategoryId
        ]);
        $newCategoryId = CategoryIdMother::create('ID-CATEGORY-0');

        // act
        $ticket->changeCategory($newCategoryId);

        // assert
        $this->assertEventNotRaised(TicketCategoryChanged::class, $ticket);
    }

    public function testChangeCategory_HaveNewCategory_TicketCategoryChangedEventRaised(): void
    {
        // arrange
        $id = TicketIdMother::createDefault();
        $oldCategoryId = CategoryIdMother::create('ID-CATEGORY-0');
        $ticket = TicketMother::createWithParams([
            'id' => $id,
            'category_id' => $oldCategoryId
        ]);
        $newCategoryId = CategoryIdMother::create('ID-CATEGORY-1');
        $occurredOnAsString = '2020-01-01 10:00:06';
        FakeCalendar::setFakeDate($occurredOnAsString);

        // act
        $ticket->changeCategory($newCategoryId);

        // assert
        $expectedRaisedEvent = TicketCategoryChangedMother::create($id, $newCategoryId);
        $this->assertEventRaised($expectedRaisedEvent, $ticket);
    }

    public function testResolve_HaveOpenTicket_TicketStatusHasBeenChangedToResolve(): void
    {
        // arrange
        $ticket = TicketMother::createDefault();

        // act
        $ticket->resolve();
        $status = $ticket->status();

        // assert
        $expectedStatus = TicketStatus::resolved();
        $this->assertEquals($expectedStatus, $status);
    }

    public function testResolve_HaveAlreadyResolvedTicket_TicketResolvedEventNotRaised(): void
    {
        // arrange
        $ticket = TicketMother::createResolved();
        $ticket->popRaisedEvents(); // clean raised events

        // act
        $ticket->resolve();

        // assert
        $this->assertEventNotRaised(TicketResolved::class, $ticket);
    }

    public function testResolve_HaveOpenTicket_TicketResolvedEventRaised(): void
    {
        // arrange
        $id = TicketIdMother::createDefault();
        $ticket = TicketMother::createWithParams([
            'id' => $id
        ]);
        $occurredOnAsString = '2020-01-01 10:00:06';
        FakeCalendar::setFakeDate($occurredOnAsString);

        // act
        $ticket->resolve();

        // assert
        $expectedRaisedEvent = TicketResolvedMother::create($id);
        $this->assertEventRaised($expectedRaisedEvent, $ticket);
    }

    public function testAddComment_TicketIsClosedAndCommentCannotBeAdded_ThrownException(): void
    {
        // arrange
        $ticket = TicketMother::createClosed();

        // assert
        $this->expectException(LockedTicketCannotBeChanged::class);

        // act
        $ticket->addComment(
            CommentIdMother::createDefault(),
            CommentContentMother::createDefault(),
            UserIdMother::createDefault()
        );
    }

    public function testAddComment_TicketIsResolvedAndCommentCannotBeAdded_ThrownException(): void
    {
        // arrange
        $ticket = TicketMother::createResolved();

        // assert
        $this->expectException(LockedTicketCannotBeChanged::class);

        // act
        $ticket->addComment(
            CommentIdMother::createDefault(),
            CommentContentMother::createDefault(),
            UserIdMother::createDefault()
        );
    }

    public function testAddComment_HaveAllDataToCreateCommentAndTicketIsOpen_CommentHasBeenCreated(): void
    {
        // arrange
        $expectedTicketId = TicketIdMother::createDefault();
        $ticket = TicketMother::createWithParams([
            'id' => $expectedTicketId
        ]);
        $expectedCommentId = CommentIdMother::createDefault();
        $expectedContent = CommentContentMother::createDefault();
        $expectedAuthorId = UserIdMother::createDefault();
        FakeCalendar::setFakeDate('2020-01-01 15:45:05');

        // act
        $comment = $ticket->addComment(
            $expectedCommentId,
            $expectedContent,
            $expectedAuthorId
        );
        $commentId = $comment->id();
        $content = $comment->content();
        $authorId = $comment->authorId();
        $ticketId = $comment->ticketId();
        $createdAt = $comment->createdAt();

        // assert
        $this->assertEquals($expectedCommentId, $commentId);
        $this->assertEquals($expectedContent, $content);
        $this->assertEquals($expectedAuthorId, $authorId);
        $this->assertEquals($expectedTicketId, $ticketId);
        $expectedCreatedAt = new \DateTimeImmutable('2020-01-01 15:45:05');
        $this->assertEquals($expectedCreatedAt, $createdAt);
    }

    private function assertEventRaised(DomainEvent $expectedEvent, Ticket $ticket): void
    {
        $eventRaised = false;
        foreach ($ticket->popRaisedEvents() as $raisedEvent) {
            if ($expectedEvent == $raisedEvent) {
                $eventRaised = true;
                break;
            }
        }

        $this->assertTrue($eventRaised);
    }

    private function assertEventNotRaised(string $eventClass, Ticket $ticket): void
    {
        $eventRaised = false;
        foreach ($ticket->popRaisedEvents() as $raisedEvent) {
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