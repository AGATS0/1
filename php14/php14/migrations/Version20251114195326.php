<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251114195326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_file (id INT AUTO_INCREMENT NOT NULL, order_id INT NOT NULL, file_path VARCHAR(255) NOT NULL, INDEX IDX_C16E0C078D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_file ADD CONSTRAINT FK_C16E0C078D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE `order` DROP file_path');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_file DROP FOREIGN KEY FK_C16E0C078D9F6D38');
        $this->addSql('DROP TABLE order_file');
        $this->addSql('ALTER TABLE `order` ADD file_path VARCHAR(255) DEFAULT NULL');
    }
}
