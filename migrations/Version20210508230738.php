<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210508230738 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE group_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE grade_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "sgroup_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE grade (id INT NOT NULL, student_id INT NOT NULL, classes_id INT NOT NULL, grade DOUBLE PRECISION NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_595AAE34CB944F1A ON grade (student_id)');
        $this->addSql('CREATE INDEX IDX_595AAE349E225B24 ON grade (classes_id)');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_595AAE34CB944F1A FOREIGN KEY (student_id) REFERENCES "student" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_595AAE349E225B24 FOREIGN KEY (classes_id) REFERENCES classes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE grade_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "sgroup_id_seq" CASCADE');
        $this->addSql('CREATE SEQUENCE group_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE grade');
    }
}
