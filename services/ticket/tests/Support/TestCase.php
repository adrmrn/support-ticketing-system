<?php
declare(strict_types=1);

namespace Ticket\Tests\Support;

use Ticket\Domain\Aggregate;
use Ticket\Domain\Event\DomainEvent;
use Ticket\Tests\Support\Helpers\Shared\Domain\FakeCalendar;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function assertEventRaised(DomainEvent $expectedEvent, Aggregate $aggregate): void
    {
        $eventRaised = false;
        foreach ($aggregate->popRaisedEvents() as $raisedEvent) {
            if ($expectedEvent == $raisedEvent) {
                $eventRaised = true;
                break;
            }
        }

        $this->assertTrue($eventRaised);
    }

    protected function assertEventNotRaised(string $eventClass, Aggregate $aggregate): void
    {
        $eventRaised = false;
        foreach ($aggregate->popRaisedEvents() as $raisedEvent) {
            if (get_class($raisedEvent) === $eventClass) {
                $eventRaised = true;
                break;
            }
        }

        $this->assertFalse($eventRaised);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        FakeCalendar::destroy();
    }
}