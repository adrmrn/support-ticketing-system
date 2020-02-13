<?php
declare(strict_types=1);

namespace Ticket\Domain\Exception;

use Ticket\Domain\Category\CategoryId;
use Ticket\Domain\NotFoundException;

final class CategoryNotFound extends NotFoundException
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function withCategoryId(CategoryId $categoryId): CategoryNotFound
    {
        return new self(
            sprintf('Category not found. Category ID: %s', (string)$categoryId)
        );
    }
}