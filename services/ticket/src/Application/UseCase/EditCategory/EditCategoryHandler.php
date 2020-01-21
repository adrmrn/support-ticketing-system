<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\EditCategory;

use Ticket\Application\Exception\PermissionException;
use Ticket\Domain\Category\CategoryId;
use Ticket\Domain\Category\CategoryName;
use Ticket\Domain\Category\CategoryPermissionService;
use Ticket\Domain\Category\CategoryRepository;
use Ticket\Domain\User\UserId;

class EditCategoryHandler
{
    private CategoryRepository $categoryRepository;
    private CategoryPermissionService $categoryPermissionService;

    public function __construct(
        CategoryRepository $categoryRepository,
        CategoryPermissionService $categoryPermissionService
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->categoryPermissionService = $categoryPermissionService;
    }

    public function handle(EditCategoryCommand $command): void
    {
        $user = $command->executor();
        if (!$this->categoryPermissionService->canUserManageCategory($user)) {
            throw PermissionException::withMessage('User cannot edit category.');
        }

        $category = $this->categoryRepository->getById(
            CategoryId::fromString($command->categoryId())
        );
        $category->rename(new CategoryName($command->name()));
    }
}