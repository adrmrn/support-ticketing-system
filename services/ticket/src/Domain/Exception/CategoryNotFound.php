<?php
declare(strict_types=1);

namespace Ticket\Domain\Exception;

use Ticket\Domain\Category\CategoryId;

final class CategoryNotFound extends \Exception
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