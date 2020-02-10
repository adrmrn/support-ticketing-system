<?php
declare(strict_types=1);

namespace Ticket\Domain\Ticket;

final class TicketDescription
{
    private const DESCRIPTION_MIN_LENGTH = 1;
    private const DESCRIPTION_MAX_LENGTH = 10_000;

    private string $description;

    public function __construct(string $description)
    {
        if (mb_strlen($description) < self::DESCRIPTION_MIN_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('Description must contains minimum %d characters.', self::DESCRIPTION_MIN_LENGTH)
            );
        }

        if (mb_strlen($description) > self::DESCRIPTION_MAX_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('Description must contains maximum %d characters.', self::DESCRIPTION_MAX_LENGTH)
            );
        }

        $this->description = $description;
    }

    public function equals(TicketDescription $description): bool
    {
        return $this->description === $description->description;
    }

    public function __toString(): string
    {
        return $this->description;
    }
}