<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\MessageReceiver;
use Illuminate\Console\Command;

class MessageConsumer extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'messaging:consume';
    protected $signature = 'messaging:consume {exchangeName=domain.events}';

    public function handle(MessageReceiver $messageReceiver)
    {
        $exchangeName = $this->argument('exchangeName');
        $messageReceiver->receiveMessages($exchangeName);
    }
}
