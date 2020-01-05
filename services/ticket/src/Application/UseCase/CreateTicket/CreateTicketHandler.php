<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\CreateTicket;

use Ticket\Domain\Category\CategoryId;
use Ticket\Domain\Category\CategoryRepository;
use Ticket\Domain\Ticket\Ticket;
use Ticket\Domain\Ticket\TicketDescription;
use Ticket\Domain\Ticket\TicketRepository;
use Ticket\Domain\Ticket\TicketTitle;
use Ticket\Domain\User\UserId;

class CreateTicketHandler
{
    private TicketRepository $ticketRepository;
    private CategoryRepository $categoryRepository;

    public function __construct(TicketRepository $ticketRepository, CategoryRepository $categoryRepository)
    {
        $this->ticketRepository = $ticketRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function handle(CreateTicketCommand $command): void
    {
        $category = $this->categoryRepository->getById(
            CategoryId::fromString($command->categoryId())
        );
        $ticket = new Ticket(
            $this->ticketRepository->nextIdentity(),
            new TicketTitle($command->title()),
            new TicketDescription($command->description()),
            $category->id(),
            UserId::fromString($command->authorId())
        );
        $this->ticketRepository->add($ticket);
    }
}