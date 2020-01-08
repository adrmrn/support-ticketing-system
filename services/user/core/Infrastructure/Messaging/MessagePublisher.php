<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Messaging;

use User\Core\Domain\Event\EventStore;

class MessagePublisher
{
    private EventStore $eventStore;
    private PublishedMessageTracker $publishedMessageTracker;
    private MessageProducer $messageProducer;
    private EventNameTranslator $eventNameTranslator;

    public function __construct(
        EventStore $eventStore,
        PublishedMessageTracker $publishedMessageTracker,
        MessageProducer $messageProducer,
        EventNameTranslator $eventNameTranslator
    ) {
        $this->eventStore = $eventStore;
        $this->publishedMessageTracker = $publishedMessageTracker;
        $this->messageProducer = $messageProducer;
        $this->eventNameTranslator = $eventNameTranslator;
    }

    public function publishMessages(string $exchangeName): void
    {
        $lastStoredEventId = $this->publishedMessageTracker->mostRecentPublishedEventId($exchangeName);
        $unpublishedEvents = $this->eventStore->allStoredEventsSince($lastStoredEventId);

        if (\count($unpublishedEvents) === 0) {
            return;
        }

        $this->messageProducer->open($exchangeName);
        $lastPublishedEvent = null;
        foreach ($unpublishedEvents as $unpublishedEvent) {
            $lastPublishedEvent = $unpublishedEvent;
            $translatedEventName = $this->eventNameTranslator->translate(
                $unpublishedEvent->eventName()
            );

            $this->messageProducer->send(
                $exchangeName,
                $unpublishedEvent->dataAsJson(),
                $translatedEventName,
                $unpublishedEvent->eventId(),
                $unpublishedEvent->occurredOn()
            );
        }

        $this->publishedMessageTracker->trackMostRecentPublishedMessage($exchangeName, $lastPublishedEvent);
        $this->messageProducer->close();
    }
}
