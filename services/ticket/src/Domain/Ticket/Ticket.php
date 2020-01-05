<?php
declare(strict_types=1);

namespace Ticket\Domain\Ticket;

use Ticket\Domain\Category\CategoryId;
use Ticket\Domain\Comment\Comment;
use Ticket\Domain\Comment\CommentContent;
use Ticket\Domain\Comment\CommentId;
use Ticket\Domain\Exception\LockedTicketCannotBeChanged;
use Ticket\Domain\Exception\ResolvedTicketCannotBeClosed;
use Ticket\Domain\User\UserId;
use Ticket\Shared\Domain\Calendar;

class Ticket
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

        $this->title = $title;
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

        $this->description = $description;
    }

    public function changeCategory(CategoryId $categoryId): void
    {
        if (!$this->status()->equals(TicketStatus::open())) {
            throw LockedTicketCannotBeChanged::withTicketId($this->id());
        }

        $this->categoryId = $categoryId;
    }

    public function resolve(): void
    {
        $this->status = TicketStatus::resolved();
    }

    /**
     * @throws ResolvedTicketCannotBeClosed
     */
    public function close(): void
    {
        if ($this->status()->equals(TicketStatus::resolved())) {
            throw ResolvedTicketCannotBeClosed::withTicketId($this->id());
        }

        $this->status = TicketStatus::closed();
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