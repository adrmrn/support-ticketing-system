<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\EditTicket;

use Ticket\Domain\User\User;

class EditTicketCommand
{
    private string $ticketId;
    private string $title;
    private string $description;
    private string $categoryId;
    private User $executor;

    public function __construct(
        string $ticketId,
        string $title,
        string $description,
        string $categoryId,
        User $executor
    ) {
        $this->ticketId = $ticketId;
        $this->title = $title;
        $this->description = $description;
        $this->categoryId = $categoryId;
        $this->executor = $executor;
    }

    public function ticketId(): string
    {
        return $this->ticketId;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function categoryId(): string
    {
        return $this->categoryId;
    }

    public function executor(): User
    {
        return $this->executor;
    }
}