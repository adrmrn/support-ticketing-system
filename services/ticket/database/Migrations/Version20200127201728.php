<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200127201728 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create events table';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('events');
        $table->addColumn('id', 'bigint', ['autoincrement' => true, 'unsigned' => true]);
        $table->addColumn('event_name', 'string');
        $table->addColumn('aggregate_id', 'uuid');
        $table->addColumn('occurred_on', 'datetime');
        $table->addColumn('version', 'integer');
        $table->addColumn('event_data', 'json');

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('events');
    }
}
