<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\EditCategory;

use Ticket\Domain\Category\CategoryId;
use Ticket\Domain\Category\CategoryName;
use Ticket\Domain\Category\CategoryRepository;

class EditCategoryHandler
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function handle(EditCategoryCommand $command): void
    {
        $category = $this->categoryRepository->getById(
            CategoryId::fromString($command->categoryId())
        );
        $category->rename(new CategoryName($command->name()));
    }
}