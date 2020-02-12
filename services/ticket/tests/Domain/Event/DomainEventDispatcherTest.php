<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Event;

use Ticket\Domain\Event\DomainEvent;
use Ticket\Tests\Support\Helpers\Infrastructure\Domain\Event\FakeAlwaysSatisfiedDomainEventSubscriber;
use Ticket\Tests\Support\Helpers\Infrastructure\Domain\Event\FakeNeverSatisfiedDomainEventSubscriber;
use Ticket\Tests\Support\MotherObject\Domain\Event\DomainEventDispatcherMother;
use Ticket\Tests\Support\TestCase;

class DomainEventDispatcherTest extends TestCase
{
    public function testHandle_HaveSubscriberThatIsSubscribedToEvent_EventHasBeenHandledBySubscriber(): void
    {
        // arrange
        $subscriber = $this->eventSubscriber_AlwaysSatisfied();
        $eventDispatcher = DomainEventDispatcherMother::createWithSubscribers($subscriber);
        $event = $this->event();

        // act
        $eventDispatcher->dispatch($event);
        $hasBeenAnyEventHandled = $subscriber->hasBeenAnyEventHandled();
        $lastHandledEvent = $subscriber->lastHandledEvent();

        // assert
        $this->assertTrue($hasBeenAnyEventHandled);
        $this->assertEquals($event, $lastHandledEvent);
    }

    public function testHandle_HaveSubscriberThatIsNotSubscribedToEvent_EventHasNotBeenHandledBySubscriber(): void
    {
        // arrange
        $subscriber = $this->eventSubscriber_NeverSatisfied();
        $eventDispatcher = DomainEventDispatcherMother::createWithSubscribers($subscriber);
        $event = $this->event();

        // act
        $eventDispatcher->dispatch($event);
        $hasBeenAnyEventHandled = $subscriber->hasBeenAnyEventHandled();

        // assert
        $this->assertFalse($hasBeenAnyEventHandled);
    }

    private function eventSubscriber_AlwaysSatisfied(): FakeAlwaysSatisfiedDomainEventSubscriber
    {
        return new FakeAlwaysSatisfiedDomainEventSubscriber();
    }

    private function eventSubscriber_NeverSatisfied(): FakeNeverSatisfiedDomainEventSubscriber
    {
        return new FakeNeverSatisfiedDomainEventSubscriber();
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|DomainEvent
     */
    private function event()
    {
        return $this->createMock(DomainEvent::class);
    }
}