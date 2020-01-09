<?php
declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MessagePublisher extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'messaging:publish';
    protected $signature = 'messaging:publish {exchangeName=domain.events}';

    public function handle(\User\Core\Infrastructure\Messaging\MessagePublisher $messagePublisher)
    {
        $exchangeName = $this->argument('exchangeName');
        $messagePublisher->publishMessages($exchangeName);
    }
}
