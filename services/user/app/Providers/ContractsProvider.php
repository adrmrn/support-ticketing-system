<?php
declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use User\Core\Application\PasswordHashing;
use User\Core\Application\Query\UserQuery;
use User\Core\Domain\User\UserRepository;
use User\Core\Infrastructure\Application\Query\MySqlUserQuery;
use User\Core\Infrastructure\Domain\User\DoctrineUserRepository;
use User\Core\Infrastructure\Domain\Event\DoctrineEventStore;
use User\Core\Domain\Event\EventStore;
use User\Core\Infrastructure\Application\BcryptPasswordHashing;
use User\Core\Infrastructure\Messaging\MessageProducer;
use User\Core\Infrastructure\Messaging\MySqlPublishedMessageTracker;
use User\Core\Infrastructure\Messaging\PublishedMessageTracker;
use User\Core\Infrastructure\Messaging\RabbitMq\RabbitMqMessageProducer;

class ContractsProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepository::class, DoctrineUserRepository::class);
        $this->app->bind(PasswordHashing::class, BcryptPasswordHashing::class);
        $this->app->bind(EventStore::class, DoctrineEventStore::class);
        $this->app->bind(PublishedMessageTracker::class, MySqlPublishedMessageTracker::class);
        $this->app->bind(MessageProducer::class, RabbitMqMessageProducer::class);
        $this->app->bind(UserQuery::class, MySqlUserQuery::class);
    }
}
