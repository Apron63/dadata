<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210822213054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, district_id INT DEFAULT NULL, city_id INT DEFAULT NULL, street_id INT DEFAULT NULL, house_id INT DEFAULT NULL, value VARCHAR(1024) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_D4E6F8198260155 (region_id), INDEX IDX_D4E6F81B08FA272 (district_id), INDEX IDX_D4E6F818BAC62AF (city_id), INDEX IDX_D4E6F8187CF8EB (street_id), INDEX IDX_D4E6F816BB74515 (house_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, fias_id VARCHAR(100) NOT NULL, name VARCHAR(100) NOT NULL, type VARCHAR(50) NOT NULL, INDEX idx_fias (fias_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE district (id INT AUTO_INCREMENT NOT NULL, fias_id VARCHAR(100) NOT NULL, name VARCHAR(100) NOT NULL, type VARCHAR(50) NOT NULL, INDEX idx_fias (fias_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE house (id INT AUTO_INCREMENT NOT NULL, fias_id VARCHAR(100) NOT NULL, name VARCHAR(100) NOT NULL, type VARCHAR(50) NOT NULL, INDEX idx_fias (fias_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, fias_id VARCHAR(100) NOT NULL, name VARCHAR(100) NOT NULL, type VARCHAR(50) NOT NULL, INDEX idx_fias (fias_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE street (id INT AUTO_INCREMENT NOT NULL, fias_id VARCHAR(100) NOT NULL, name VARCHAR(100) NOT NULL, type VARCHAR(50) NOT NULL, INDEX idx_fias (fias_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F8198260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81B08FA272 FOREIGN KEY (district_id) REFERENCES district (id)');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F818BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F8187CF8EB FOREIGN KEY (street_id) REFERENCES street (id)');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F816BB74515 FOREIGN KEY (house_id) REFERENCES house (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F818BAC62AF');
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F81B08FA272');
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F816BB74515');
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F8198260155');
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F8187CF8EB');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE district');
        $this->addSql('DROP TABLE house');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE street');
    }
}
