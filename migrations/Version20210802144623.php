<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210802144623 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE year_of_study_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE year_of_study (id INT NOT NULL, year INT NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE semester ADD year_of_study_id INT NOT NULL');
        $this->addSql('ALTER TABLE semester ADD semester INT NOT NULL');
        $this->addSql('ALTER TABLE semester DROP number');
        $this->addSql('ALTER TABLE semester DROP year_of_study');
        $this->addSql('ALTER TABLE semester ADD CONSTRAINT FK_F7388EED2A262BF9 FOREIGN KEY (year_of_study_id) REFERENCES year_of_study (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F7388EED2A262BF9 ON semester (year_of_study_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE semester DROP CONSTRAINT FK_F7388EED2A262BF9');
        $this->addSql('DROP SEQUENCE year_of_study_id_seq CASCADE');
        $this->addSql('DROP TABLE year_of_study');
        $this->addSql('DROP INDEX IDX_F7388EED2A262BF9');
        $this->addSql('ALTER TABLE semester ADD number INT NOT NULL');
        $this->addSql('ALTER TABLE semester ADD year_of_study INT NOT NULL');
        $this->addSql('ALTER TABLE semester DROP year_of_study_id');
        $this->addSql('ALTER TABLE semester DROP semester');
    }
}
