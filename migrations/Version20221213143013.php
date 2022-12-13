<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221213143013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE update_ticket_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE update_ticket (id INT NOT NULL, heroe_id INT NOT NULL, author_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_94762B4D77D25060 ON update_ticket (heroe_id)');
        $this->addSql('CREATE INDEX IDX_94762B4DF675F31B ON update_ticket (author_id)');
        $this->addSql('ALTER TABLE update_ticket ADD CONSTRAINT FK_94762B4D77D25060 FOREIGN KEY (heroe_id) REFERENCES heroes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE update_ticket ADD CONSTRAINT FK_94762B4DF675F31B FOREIGN KEY (author_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE update_ticket_id_seq CASCADE');
        $this->addSql('ALTER TABLE update_ticket DROP CONSTRAINT FK_94762B4D77D25060');
        $this->addSql('ALTER TABLE update_ticket DROP CONSTRAINT FK_94762B4DF675F31B');
        $this->addSql('DROP TABLE update_ticket');
    }
}
