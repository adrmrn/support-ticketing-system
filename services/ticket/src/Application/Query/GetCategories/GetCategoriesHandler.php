<?php
declare(strict_types=1);

namespace Ticket\Application\Query\GetCategories;

use Ticket\Domain\Category\CategoryView;
use Ticket\Domain\Category\CategoryViewRepository;
use Ticket\Shared\Application\Query\Handler;

class GetCategoriesHandler implements Handler
{
    private CategoryViewRepository $categoryViewRepository;

    public function __construct(CategoryViewRepository $categoryViewRepository)
    {
        $this->categoryViewRepository = $categoryViewRepository;
    }

    /**
     * @param GetCategoriesQuery $query
     * @return CategoryView[]
     */
    public function handle(GetCategoriesQuery $query): array
    {
        return $this->categoryViewRepository->getAll();
    }
}