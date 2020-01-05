<?php
declare(strict_types=1);

namespace Ticket\Domain\Category;

final class CategoryName
{
    private const NAME_MIN_LENGTH = 1;
    private const NAME_MAX_LENGTH = 100;

    private string $name;

    public function __construct(string $name)
    {
        if (mb_strlen($name) < self::NAME_MIN_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('Name must contains minimum %d characters.', self::NAME_MIN_LENGTH)
            );
        }

        if (mb_strlen($name) > self::NAME_MAX_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('Name must contains maximum %d characters.', self::NAME_MAX_LENGTH)
            );
        }

        $this->name = $name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}