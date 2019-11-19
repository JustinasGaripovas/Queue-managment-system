<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191010073001 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE interest_type (id INT AUTO_INCREMENT NOT NULL, interest_type_id INT DEFAULT NULL, full_name VARCHAR(255) NOT NULL, code VARCHAR(20) NOT NULL, INDEX IDX_22F0D7A5CA36FB5D (interest_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE interest_type ADD CONSTRAINT FK_22F0D7A5CA36FB5D FOREIGN KEY (interest_type_id) REFERENCES interest_type (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE interest_type DROP FOREIGN KEY FK_22F0D7A5CA36FB5D');
        $this->addSql('DROP TABLE interest_type');
    }
}
