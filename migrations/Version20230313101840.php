<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230313101840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offer CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE permanent_name permanent_name VARCHAR(50) DEFAULT NULL, CHANGE permanent_validity_beginning permanent_validity_beginning DATETIME DEFAULT NULL, CHANGE permanent_validity_ending permanent_validity_ending DATETIME DEFAULT NULL, CHANGE limited_display_beginning limited_display_beginning DATETIME DEFAULT NULL, CHANGE limited_display_ending limited_display_ending DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE offer CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\', CHANGE permanent_name permanent_name VARCHAR(50) DEFAULT \'NULL\', CHANGE permanent_validity_beginning permanent_validity_beginning DATETIME DEFAULT \'NULL\', CHANGE permanent_validity_ending permanent_validity_ending DATETIME DEFAULT \'NULL\', CHANGE limited_display_beginning limited_display_beginning DATETIME DEFAULT \'NULL\', CHANGE limited_display_ending limited_display_ending DATETIME DEFAULT \'NULL\'');
    }
}
