<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221202143053 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE heroe_background_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE heroe_background (id INT NOT NULL, heroe_id INT DEFAULT NULL, media_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F18734AA77D25060 ON heroe_background (heroe_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F18734AAEA9FDD75 ON heroe_background (media_id)');
        $this->addSql('ALTER TABLE heroe_background ADD CONSTRAINT FK_F18734AA77D25060 FOREIGN KEY (heroe_id) REFERENCES heroes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE heroe_background ADD CONSTRAINT FK_F18734AAEA9FDD75 FOREIGN KEY (media_id) REFERENCES medias (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE heroe_background_id_seq CASCADE');
        $this->addSql('ALTER TABLE heroe_background DROP CONSTRAINT FK_F18734AA77D25060');
        $this->addSql('ALTER TABLE heroe_background DROP CONSTRAINT FK_F18734AAEA9FDD75');
        $this->addSql('DROP TABLE heroe_background');
    }
}
