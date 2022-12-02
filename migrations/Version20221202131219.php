<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221202131219 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE role_icon_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE role_icon (id INT NOT NULL, role_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DB2B5B4FD60322AC ON role_icon (role_id)');
        $this->addSql('ALTER TABLE role_icon ADD CONSTRAINT FK_DB2B5B4FD60322AC FOREIGN KEY (role_id) REFERENCES roles (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE medias DROP role');
        $this->addSql('ALTER TABLE roles DROP CONSTRAINT fk_b63e2ec754b9d732');
        $this->addSql('DROP INDEX uniq_b63e2ec754b9d732');
        $this->addSql('ALTER TABLE roles DROP icon_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE role_icon_id_seq CASCADE');
        $this->addSql('ALTER TABLE role_icon DROP CONSTRAINT FK_DB2B5B4FD60322AC');
        $this->addSql('DROP TABLE role_icon');
        $this->addSql('ALTER TABLE medias ADD role VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE roles ADD icon_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE roles ADD CONSTRAINT fk_b63e2ec754b9d732 FOREIGN KEY (icon_id) REFERENCES medias (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_b63e2ec754b9d732 ON roles (icon_id)');
    }
}
