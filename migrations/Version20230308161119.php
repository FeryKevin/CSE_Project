<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230308161119 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE limited_offer (id INT AUTO_INCREMENT NOT NULL, published_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, description VARCHAR(255) NOT NULL, display_beginning DATETIME NOT NULL, display_ending DATETIME NOT NULL, display_number INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permanent_offer (id INT AUTO_INCREMENT NOT NULL, published_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, description VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, validity_beginning DATETIME NOT NULL, validity_ending DATETIME NOT NULL, minimum_places INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE limited_offer');
        $this->addSql('DROP TABLE permanent_offer');
    }
}
