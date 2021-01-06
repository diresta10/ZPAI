<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201216193345 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE "student_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "student" (id INT NOT NULL, address_id INT DEFAULT NULL, group_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, firstname TEXT NOT NULL, lastname TEXT NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B723AF33E7927C74 ON "student" (email)');
        $this->addSql('CREATE INDEX IDX_B723AF33F5B7AF75 ON "student" (address_id)');
        $this->addSql('CREATE INDEX IDX_B723AF33FE54D947 ON "student" (group_id)');
        $this->addSql('ALTER TABLE "student" ADD CONSTRAINT FK_B723AF33F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "student" ADD CONSTRAINT FK_B723AF33FE54D947 FOREIGN KEY (group_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE "user"');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE "student_id_seq" CASCADE');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, address_id INT DEFAULT NULL, group_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, firstname TEXT NOT NULL, lastname TEXT NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_8d93d649f5b7af75 ON "user" (address_id)');
        $this->addSql('CREATE INDEX idx_8d93d649fe54d947 ON "user" (group_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_8d93d649e7927c74 ON "user" (email)');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT fk_8d93d649f5b7af75 FOREIGN KEY (address_id) REFERENCES address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT fk_8d93d649fe54d947 FOREIGN KEY (group_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE "student"');
    }
}
