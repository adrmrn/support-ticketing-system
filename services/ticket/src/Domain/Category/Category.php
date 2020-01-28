<?php
declare(strict_types=1);

namespace Ticket\Domain\Category;

use Ticket\Domain\Category\Event\CategoryCreated;
use Ticket\Domain\Category\Event\CategoryNameChanged;
use Ticket\Shared\Domain\Aggregate;

class Category extends Aggregate
{
    private CategoryId $id;
    private CategoryName $name;

    public function __construct(CategoryId $id, CategoryName $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->raiseEvent(
            new CategoryCreated(
                $this->id(),
                $this->name()
            )
        );
    }

    public function rename(CategoryName $name): void
    {
        if ($this->name()->equals($name)) {
            return;
        }

        $this->name = $name;
        $this->raiseEvent(
            new CategoryNameChanged(
                $this->id(),
                $this->name()
            )
        );
    }

    public function id(): CategoryId
    {
        return $this->id;
    }

    public function name(): CategoryName
    {
        return $this->name;
    }
}