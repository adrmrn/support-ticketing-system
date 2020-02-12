<?php
declare(strict_types=1);

namespace Ticket\Domain;

trait AggregateId
{
    private string $id;

    private function __construct(string $id)
    {
        if (strlen($id) === 0) {
            throw new \InvalidArgumentException('ID string is empty');
        }

        $this->id = $id;
    }

    public static function fromString(string $id)
    {
        return new static($id);
    }

    public function __toString(): string
    {
        return $this->id;
    }

    public function equals($otherAggregateId): bool
    {
        return get_class($otherAggregateId) === get_class($this)
            && (string)$this === (string)$otherAggregateId;
    }
}