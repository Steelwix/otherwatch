<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221128101827 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE heroes ADD countering_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE heroes ADD CONSTRAINT FK_578C8FC7DE6B703B FOREIGN KEY (countering_id) REFERENCES heroes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_578C8FC7DE6B703B ON heroes (countering_id)');
        $this->addSql('ALTER TABLE roles ADD role_icons VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE roles DROP role_icons');
        $this->addSql('ALTER TABLE heroes DROP CONSTRAINT FK_578C8FC7DE6B703B');
        $this->addSql('DROP INDEX IDX_578C8FC7DE6B703B');
        $this->addSql('ALTER TABLE heroes DROP countering_id');
    }
}
