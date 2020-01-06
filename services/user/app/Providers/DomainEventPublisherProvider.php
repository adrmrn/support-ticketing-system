<?php
declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use User\Core\Shared\Domain\Event\DomainEventPublisher;
use User\Core\Shared\Domain\Event\PersistDomainEventSubscriber;

class DomainEventPublisherProvider extends ServiceProvider
{
    public function boot(): void
    {
        DomainEventPublisher::instance()->subscribe(
            $this->app->get(PersistDomainEventSubscriber::class)
        );
    }
}
