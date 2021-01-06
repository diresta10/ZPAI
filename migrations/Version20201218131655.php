<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201218131655 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE classes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE subject_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE classes (id INT NOT NULL, subject_id INT DEFAULT NULL, teacher_id INT DEFAULT NULL, group_id INT DEFAULT NULL, day TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2ED7EC523EDC87 ON classes (subject_id)');
        $this->addSql('CREATE INDEX IDX_2ED7EC541807E1D ON classes (teacher_id)');
        $this->addSql('CREATE INDEX IDX_2ED7EC5FE54D947 ON classes (group_id)');
        $this->addSql('CREATE TABLE subject (id INT NOT NULL, subject_name TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE classes ADD CONSTRAINT FK_2ED7EC523EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE classes ADD CONSTRAINT FK_2ED7EC541807E1D FOREIGN KEY (teacher_id) REFERENCES "teacher" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE classes ADD CONSTRAINT FK_2ED7EC5FE54D947 FOREIGN KEY (group_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teacher ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE teacher ADD password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE teacher ALTER email TYPE VARCHAR(180)');
        $this->addSql('ALTER TABLE teacher ALTER email DROP DEFAULT');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE classes DROP CONSTRAINT FK_2ED7EC523EDC87');
        $this->addSql('DROP SEQUENCE classes_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE subject_id_seq CASCADE');
        $this->addSql('DROP TABLE classes');
        $this->addSql('DROP TABLE subject');
        $this->addSql('ALTER TABLE "teacher" DROP roles');
        $this->addSql('ALTER TABLE "teacher" DROP password');
        $this->addSql('ALTER TABLE "teacher" ALTER email TYPE TEXT');
        $this->addSql('ALTER TABLE "teacher" ALTER email DROP DEFAULT');
        $this->addSql('ALTER TABLE "teacher" ALTER email TYPE TEXT');
    }
}
