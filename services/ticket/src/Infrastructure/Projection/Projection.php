<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Projection;

use Ticket\Domain\Event\DomainEvent;

interface Projection
{
    public function isListeningTo(DomainEvent $event): bool;

    public function project(DomainEvent $event): void;
}