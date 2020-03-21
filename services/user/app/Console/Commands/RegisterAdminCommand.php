<?php
declare(strict_types=1);

namespace App\Console\Commands;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Console\Command;
use User\Core\Application\UseCase\RegisterAdmin\RegisterAdmin;
use User\Core\Application\UseCase\RegisterAdmin\RegisterAdminRequest;

class RegisterAdminCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'admin:register';
    protected $signature = 'admin:register {email} {firstName} {lastName} {password}';
    private RegisterAdmin $registerAdmin;

    public function handle(EntityManagerInterface $entityManager, RegisterAdmin $registerAdmin)
    {
        $request = new RegisterAdminRequest(
            $this->argument('email'),
            $this->argument('firstName'),
            $this->argument('lastName'),
            $this->argument('password')
        );

        try {
            $entityManager->beginTransaction();

            $registerAdmin->execute($request);

            $entityManager->flush();
            $entityManager->commit();
        } catch (\Exception $exception) {
            $entityManager->rollback();
            throw $exception;
        }
    }
}
