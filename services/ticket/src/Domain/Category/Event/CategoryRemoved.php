<?php
declare(strict_types=1);

namespace Ticket\Domain\Category\Event;

use Ticket\Domain\Category\CategoryId;
use Ticket\Domain\Event\DomainEvent;
use Ticket\Domain\Calendar;

class CategoryRemoved implements DomainEvent
{
    private CategoryId $categoryId;
    private \DateTimeInterface $occurredOn;

    public function __construct(CategoryId $categoryId)
    {
        $this->categoryId = $categoryId;
        $this->occurredOn = Calendar::now();
    }

    public function aggregateId(): string
    {
        return (string)$this->categoryId;
    }

    public function occurredOn(): \DateTimeInterface
    {
        return $this->occurredOn;
    }

    public function version(): int
    {
        return 0;
    }

    public function data(): array
    {
        return [
            'id' => (string)$this->categoryId
        ];
    }

    public function dataAsJson(): string
    {
        return \json_encode($this->data());
    }
}