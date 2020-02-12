<?php
declare(strict_types=1);

namespace Ticket\Domain\Ticket;

use Ticket\Domain\Category\CategoryId;
use Ticket\Domain\Comment\Comment;
use Ticket\Domain\Comment\CommentContent;
use Ticket\Domain\Comment\CommentId;
use Ticket\Domain\Exception\LockedTicketCannotBeChanged;
use Ticket\Domain\Exception\ResolvedTicketCannotBeClosed;
use Ticket\Domain\Ticket\Event\TicketCategoryChanged;
use Ticket\Domain\Ticket\Event\TicketClosed;
use Ticket\Domain\Ticket\Event\TicketCreated;
use Ticket\Domain\Ticket\Event\TicketDescribed;
use Ticket\Domain\Ticket\Event\TicketResolved;
use Ticket\Domain\Ticket\Event\TicketTitleChanged;
use Ticket\Domain\User\UserId;
use Ticket\Domain\Aggregate;
use Ticket\Domain\Calendar;

class Ticket extends Aggregate
{
    private TicketId $id;
    private TicketTitle $title;
    private TicketDescription $description;
    private CategoryId $categoryId;
    private UserId $authorId;
    private TicketStatus $status;
    private \DateTimeInterface $createdAt;

    public function __construct(
        TicketId $id,
        TicketTitle $title,
        TicketDescription $description,
        CategoryId $categoryId,
        UserId $authorId
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->categoryId = $categoryId;
        $this->authorId = $authorId;
        $this->status = TicketStatus::open();
        $this->createdAt = Calendar::now();
        $this->raiseEvent(
            new TicketCreated(
                $this->id(),
                $this->title(),
                $this->description(),
                $this->categoryId(),
                $this->authorId(),
                $this->createdAt()
            )
        );
    }

    /**
     * @param TicketTitle $title
     * @throws LockedTicketCannotBeChanged
     */
    public function changeTitle(TicketTitle $title): void
    {
        if (!$this->status()->equals(TicketStatus::open())) {
            throw LockedTicketCannotBeChanged::withTicketId($this->id());
        }

        if ($this->title()->equals($title)) {
            return;
        }

        $this->title = $title;
        $this->raiseEvent(
            new TicketTitleChanged(
                $this->id(),
                $this->title()
            )
        );
    }

    /**
     * @param TicketDescription $description
     * @throws LockedTicketCannotBeChanged
     */
    public function describe(TicketDescription $description): void
    {
        if (!$this->status()->equals(TicketStatus::open())) {
            throw LockedTicketCannotBeChanged::withTicketId($this->id());
        }

        if ($this->description()->equals($description)) {
            return;
        }

        $this->description = $description;
        $this->raiseEvent(
            new TicketDescribed(
                $this->id(),
                $this->description()
            )
        );
    }

    public function changeCategory(CategoryId $categoryId): void
    {
        if (!$this->status()->equals(TicketStatus::open())) {
            throw LockedTicketCannotBeChanged::withTicketId($this->id());
        }

        if ($this->categoryId()->equals($categoryId)) {
            return;
        }

        $this->categoryId = $categoryId;
        $this->raiseEvent(
            new TicketCategoryChanged(
                $this->id(),
                $this->categoryId()
            )
        );
    }

    public function resolve(): void
    {
        if ($this->status()->equals(TicketStatus::resolved())) {
            return;
        }

        $this->status = TicketStatus::resolved();
        $this->raiseEvent(
            new TicketResolved(
                $this->id()
            )
        );
    }

    /**
     * @throws ResolvedTicketCannotBeClosed
     */
    public function close(): void
    {
        if ($this->status()->equals(TicketStatus::resolved())) {
            throw ResolvedTicketCannotBeClosed::withTicketId($this->id());
        }

        if ($this->status()->equals(TicketStatus::closed())) {
            return;
        }

        $this->status = TicketStatus::closed();
        $this->raiseEvent(
            new TicketClosed(
                $this->id()
            )
        );
    }

    /**
     * @param CommentId $commentId
     * @param CommentContent $content
     * @param UserId $authorId
     * @return Comment
     * @throws LockedTicketCannotBeChanged
     */
    public function addComment(CommentId $commentId, CommentContent $content, UserId $authorId): Comment
    {
        if (!$this->status()->equals(TicketStatus::open())) {
            throw LockedTicketCannotBeChanged::withTicketId($this->id());
        }

        return new Comment(
            $commentId,
            $content,
            $authorId,
            $this->id()
        );
    }

    public function id(): TicketId
    {
        return $this->id;
    }

    public function title(): TicketTitle
    {
        return $this->title;
    }

    public function description(): TicketDescription
    {
        return $this->description;
    }

    public function categoryId(): CategoryId
    {
        return $this->categoryId;
    }

    public function authorId(): UserId
    {
        return $this->authorId;
    }

    public function status(): TicketStatus
    {
        return $this->status;
    }

    public function createdAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
}