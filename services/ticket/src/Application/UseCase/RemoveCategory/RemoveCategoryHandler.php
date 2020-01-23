<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\RemoveCategory;

use Ticket\Application\Exception\PermissionException;
use Ticket\Domain\Category\CategoryId;
use Ticket\Domain\Category\CategoryPermissionService;
use Ticket\Domain\Category\CategoryRepository;
use Ticket\Domain\Ticket\TicketRepository;

class RemoveCategoryHandler
{
    private CategoryRepository $categoryRepository;
    private TicketRepository $ticketRepository;
    private CategoryPermissionService $categoryPermissionService;

    public function __construct(
        CategoryRepository $categoryRepository,
        TicketRepository $ticketRepository,
        CategoryPermissionService $categoryPermissionService
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->ticketRepository = $ticketRepository;
        $this->categoryPermissionService = $categoryPermissionService;
    }

    public function handle(RemoveCategoryCommand $command): void
    {
        $user = $command->executor();
        if (!$this->categoryPermissionService->canUserManageCategory($user)) {
            throw PermissionException::withMessage('User cannot manage that category.');
        }

        $category = $this->categoryRepository->getById(
            CategoryId::fromString($command->categoryId())
        );
        $tickets = $this->ticketRepository->getByCategory($category->id());
        if (\count($tickets) > 0) {
            throw PermissionException::withMessage('Category cannot be removed. Category in use.');
        }

        $this->categoryRepository->remove($category);
    }
}