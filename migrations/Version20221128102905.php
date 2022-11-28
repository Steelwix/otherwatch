<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221128102905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE heroes_heroes (heroes_source INT NOT NULL, heroes_target INT NOT NULL, PRIMARY KEY(heroes_source, heroes_target))');
        $this->addSql('CREATE INDEX IDX_6A2F05C46229F570 ON heroes_heroes (heroes_source)');
        $this->addSql('CREATE INDEX IDX_6A2F05C47BCCA5FF ON heroes_heroes (heroes_target)');
        $this->addSql('ALTER TABLE heroes_heroes ADD CONSTRAINT FK_6A2F05C46229F570 FOREIGN KEY (heroes_source) REFERENCES heroes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE heroes_heroes ADD CONSTRAINT FK_6A2F05C47BCCA5FF FOREIGN KEY (heroes_target) REFERENCES heroes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE heroes DROP CONSTRAINT fk_578c8fc7de6b703b');
        $this->addSql('DROP INDEX idx_578c8fc7de6b703b');
        $this->addSql('ALTER TABLE heroes DROP countering_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE heroes_heroes DROP CONSTRAINT FK_6A2F05C46229F570');
        $this->addSql('ALTER TABLE heroes_heroes DROP CONSTRAINT FK_6A2F05C47BCCA5FF');
        $this->addSql('DROP TABLE heroes_heroes');
        $this->addSql('ALTER TABLE heroes ADD countering_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE heroes ADD CONSTRAINT fk_578c8fc7de6b703b FOREIGN KEY (countering_id) REFERENCES heroes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_578c8fc7de6b703b ON heroes (countering_id)');
    }
}
