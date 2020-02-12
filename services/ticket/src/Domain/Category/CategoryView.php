<?php
declare(strict_types=1);

namespace Ticket\Domain\Category;

use Ticket\Domain\View;

class CategoryView implements View
{
    private string $id;
    private string $name;

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}