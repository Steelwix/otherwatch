<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221126221844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE counters_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE counters (id INT NOT NULL, playing_id INT DEFAULT NULL, enemy_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_45111491FC2DEEA5 ON counters (playing_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_45111491900C982F ON counters (enemy_id)');
        $this->addSql('ALTER TABLE counters ADD CONSTRAINT FK_45111491FC2DEEA5 FOREIGN KEY (playing_id) REFERENCES heroes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE counters ADD CONSTRAINT FK_45111491900C982F FOREIGN KEY (enemy_id) REFERENCES heroes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE counters_id_seq CASCADE');
        $this->addSql('ALTER TABLE counters DROP CONSTRAINT FK_45111491FC2DEEA5');
        $this->addSql('ALTER TABLE counters DROP CONSTRAINT FK_45111491900C982F');
        $this->addSql('DROP TABLE counters');
    }
}
