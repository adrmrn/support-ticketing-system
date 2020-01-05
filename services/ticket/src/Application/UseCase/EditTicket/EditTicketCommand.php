<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\EditTicket;

class EditTicketCommand
{
    private string $ticketId;
    private string $title;
    private string $description;
    private string $categoryId;

    public function __construct(string $ticketId, string $title, string $description, string $categoryId)
    {
        $this->ticketId = $ticketId;
        $this->title = $title;
        $this->description = $description;
        $this->categoryId = $categoryId;
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
}