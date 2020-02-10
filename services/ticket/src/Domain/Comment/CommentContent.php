<?php
declare(strict_types=1);

namespace Ticket\Domain\Comment;

final class CommentContent
{
    private const CONTENT_MIN_LENGTH = 1;
    private const CONTENT_MAX_LENGTH = 10_000;

    private string $content;

    public function __construct(string $content)
    {
        if (mb_strlen($content) < self::CONTENT_MIN_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('Content must contains minimum %d characters.', self::CONTENT_MIN_LENGTH)
            );
        }

        if (mb_strlen($content) > self::CONTENT_MAX_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('Content must contains maximum %d characters.', self::CONTENT_MAX_LENGTH)
            );
        }

        $this->content = $content;
    }

    public function equals(CommentContent $content): bool
    {
        return $this->content === $content->content;
    }

    public function __toString(): string
    {
        return $this->content;
    }
}