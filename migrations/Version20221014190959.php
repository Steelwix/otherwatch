<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221014190959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE abilities_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE abilities (id INT NOT NULL, heroes_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(2000) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B8388DA4AAB40E2D ON abilities (heroes_id)');
        $this->addSql('ALTER TABLE abilities ADD CONSTRAINT FK_B8388DA4AAB40E2D FOREIGN KEY (heroes_id) REFERENCES heroes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE abilities_id_seq CASCADE');
        $this->addSql('ALTER TABLE abilities DROP CONSTRAINT FK_B8388DA4AAB40E2D');
        $this->addSql('DROP TABLE abilities');
        $this->addSql('ALTER TABLE heroes ALTER slug DROP NOT NULL');
    }
}
