<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210703193154 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classes_grade_category (classes_id INT NOT NULL, grade_category_id INT NOT NULL, PRIMARY KEY(classes_id, grade_category_id))');
        $this->addSql('CREATE INDEX IDX_74A58A89E225B24 ON classes_grade_category (classes_id)');
        $this->addSql('CREATE INDEX IDX_74A58A888185285 ON classes_grade_category (grade_category_id)');
        $this->addSql('CREATE TABLE classes_gradecategories (grade_category_id INT NOT NULL, classes_id INT NOT NULL, PRIMARY KEY(grade_category_id, classes_id))');
        $this->addSql('CREATE INDEX IDX_430038C888185285 ON classes_gradecategories (grade_category_id)');
        $this->addSql('CREATE INDEX IDX_430038C89E225B24 ON classes_gradecategories (classes_id)');
        $this->addSql('ALTER TABLE classes_grade_category ADD CONSTRAINT FK_74A58A89E225B24 FOREIGN KEY (classes_id) REFERENCES classes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE classes_grade_category ADD CONSTRAINT FK_74A58A888185285 FOREIGN KEY (grade_category_id) REFERENCES grade_category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE classes_gradecategories ADD CONSTRAINT FK_430038C888185285 FOREIGN KEY (grade_category_id) REFERENCES grade_category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE classes_gradecategories ADD CONSTRAINT FK_430038C89E225B24 FOREIGN KEY (classes_id) REFERENCES classes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE grade_category DROP CONSTRAINT fk_48b2d7079e225b24');
        $this->addSql('DROP INDEX idx_48b2d7079e225b24');
        $this->addSql('ALTER TABLE grade_category DROP classes_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE classes_grade_category');
        $this->addSql('DROP TABLE classes_gradecategories');
        $this->addSql('ALTER TABLE grade_category ADD classes_id INT NOT NULL');
        $this->addSql('ALTER TABLE grade_category ADD CONSTRAINT fk_48b2d7079e225b24 FOREIGN KEY (classes_id) REFERENCES classes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_48b2d7079e225b24 ON grade_category (classes_id)');
    }
}
