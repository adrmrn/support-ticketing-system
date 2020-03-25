<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Delivery\Cli\Command;

use League\Tactician\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Ticket\Application\UseCase\CloseOverdueTickets\CloseOverdueTicketsCommand as CloseOverdueTicketsUseCaseCommand;

class CloseOverdueTicketsCommand extends Command
{
    protected static $defaultName = 'ticket:close-overdue';
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Close overdue Tickets.')
            ->setHelp('This command close overdue Tickets that hasn\'t had activity for some time.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Starting process...');

        $command = new CloseOverdueTicketsUseCaseCommand();
        $this->commandBus->handle($command);

        $output->writeln('Finished!');

        return 0;
    }
}