<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Messaging;

class EventNameTranslator
{
    public function translate(string $eventClassName): string
    {
        $partsOfClassName = explode('\\', $eventClassName);

        $microserviceName = array_shift($partsOfClassName);
        $eventName = array_pop($partsOfClassName);

        return sprintf(
            '%s.%s',
            $this->camelCaseToUnderscore($microserviceName),
            $this->camelCaseToUnderscore($eventName)
        );
    }

    private function camelCaseToUnderscore(string $input)
    {
        return ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $input)), '_');
    }
}
