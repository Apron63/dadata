<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210823055537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE settlement (id INT AUTO_INCREMENT NOT NULL, fias_id VARCHAR(100) NOT NULL, name VARCHAR(100) NOT NULL, type VARCHAR(50) DEFAULT NULL, INDEX idx_fias (fias_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address ADD settlement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81C2B9C425 FOREIGN KEY (settlement_id) REFERENCES settlement (id)');
        $this->addSql('CREATE INDEX IDX_D4E6F81C2B9C425 ON address (settlement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F81C2B9C425');
        $this->addSql('DROP TABLE settlement');
        $this->addSql('DROP INDEX IDX_D4E6F81C2B9C425 ON address');
        $this->addSql('ALTER TABLE address DROP settlement_id');
    }
}
