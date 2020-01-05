<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\CreateCategory;

use Ticket\Domain\Category\Category;
use Ticket\Domain\Category\CategoryName;
use Ticket\Domain\Category\CategoryRepository;

class CreateCategoryHandler
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function handle(CreateCategoryCommand $command): void
    {
        $category = new Category(
            $this->categoryRepository->nextIdentity(),
            new CategoryName($command->name())
        );
        $this->categoryRepository->add($category);
    }
}