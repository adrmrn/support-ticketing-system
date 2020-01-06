<?php
declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use User\Core\Application\PasswordHashing;
use User\Core\Domain\User\UserRepository;
use User\Core\Infrastructure\Domain\User\DoctrineUserRepository;
use User\Core\Infrastructure\Domain\Event\DoctrineEventStore;
use User\Core\Domain\Event\EventStore;
use User\Core\Infrastructure\Application\BcryptPasswordHashing;

class ContractsProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepository::class, DoctrineUserRepository::class);
        $this->app->bind(PasswordHashing::class, BcryptPasswordHashing::class);
        $this->app->bind(EventStore::class, DoctrineEventStore::class);
    }
}
