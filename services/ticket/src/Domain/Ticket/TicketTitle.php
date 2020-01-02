<?php
declare(strict_types=1);

namespace Ticket\Domain\Ticket;

final class TicketTitle
{
    private const TITLE_MIN_LENGTH = 1;
    private const TITLE_MAX_LENGTH = 255;

    private string $title;

    public function __construct(string $title)
    {
        if (strlen($title) < self::TITLE_MIN_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('Title must contains minimum %d characters.', self::TITLE_MIN_LENGTH)
            );
        }

        if (strlen($title) > self::TITLE_MAX_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('Title must contains maximum %d characters.', self::TITLE_MAX_LENGTH)
            );
        }

        $this->title = $title;
    }

    public function __toString(): string
    {
        return $this->title;
    }
}