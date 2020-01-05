<?php
declare(strict_types=1);

namespace Ticket\Domain\Ticket;

use Ticket\Domain\Category\CategoryId;
use Ticket\Domain\Comment\Comment;
use Ticket\Domain\Comment\CommentContent;
use Ticket\Domain\Comment\CommentId;
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
     * @throws \InvalidArgumentException
     */
    public function changeTitle(TicketTitle $title): void
    {
        if (!$this->status->equals(TicketStatus::open())) {
            throw new \InvalidArgumentException('Title cannot be changed. Ticket is closed.');
        }

        $this->title = $title;
    }

    /**
     * @param TicketDescription $description
     * @throws \InvalidArgumentException
     */
    public function describe(TicketDescription $description): void
    {
        if (!$this->status->equals(TicketStatus::open())) {
            throw new \InvalidArgumentException('Description cannot be changed. Ticket is closed.');
        }

        $this->description = $description;
    }

    public function resolve(): void
    {
        $this->status = TicketStatus::resolved();
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function close(): void
    {
        if ($this->status->equals(TicketStatus::resolved())) {
            throw new \InvalidArgumentException('Cannot close resolved ticket.');
        }

        $this->status = TicketStatus::closed();
    }

    /**
     * @param CommentId $commentId
     * @param CommentContent $content
     * @param UserId $authorId
     * @return Comment
     * @throws \InvalidArgumentException
     */
    public function addComment(CommentId $commentId, CommentContent $content, UserId $authorId): Comment
    {
        if (!$this->status->equals(TicketStatus::open())) {
            throw new \InvalidArgumentException('Comment cannot be added. Ticket is closed.');
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