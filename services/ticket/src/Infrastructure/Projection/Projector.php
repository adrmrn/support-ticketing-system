<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Projection;

use Ticket\Domain\Event\DomainEvent;

class Projector
{
    /**
     * @var Projection[]
     */
    private array $projections = [];

    public function register(Projection $projection): void
    {
        if (\in_array($projection, $this->projections, true)) {
            return;
        }

        $this->projections[] = $projection;
    }

    public function project(DomainEvent $event): void
    {
        foreach ($this->projections as $projection) {
            if ($projection->isListeningTo($event)) {
                $projection->project($event);
            }
        }
    }
}