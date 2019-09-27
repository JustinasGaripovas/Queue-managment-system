<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190927203318 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE queue_task_status_log (id INT AUTO_INCREMENT NOT NULL, queue_task_id INT NOT NULL, created_at INT NOT NULL, status VARCHAR(15) NOT NULL, INDEX IDX_31A7312D6F349AB8 (queue_task_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE queue_task_status_log ADD CONSTRAINT FK_31A7312D6F349AB8 FOREIGN KEY (queue_task_id) REFERENCES queue_task (id)');
        $this->addSql('ALTER TABLE queue_task CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE queue_task_status_log');
        $this->addSql('ALTER TABLE queue_task CHANGE id id INT NOT NULL');
    }
}
