<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201218220834 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE time_id_seq CASCADE');
        $this->addSql('DROP TABLE "time"');
        $this->addSql('ALTER TABLE notice ADD teacher_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notice ADD CONSTRAINT FK_480D45C241807E1D FOREIGN KEY (teacher_id) REFERENCES "teacher" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_480D45C241807E1D ON notice (teacher_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE time_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "time" (id INT NOT NULL, timesrc TIME(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE notice DROP CONSTRAINT FK_480D45C241807E1D');
        $this->addSql('DROP INDEX IDX_480D45C241807E1D');
        $this->addSql('ALTER TABLE notice DROP teacher_id');
    }
}
