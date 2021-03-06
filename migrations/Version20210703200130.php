<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210703200130 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE grade_category_classes (grade_category_id INT NOT NULL, classes_id INT NOT NULL, PRIMARY KEY(grade_category_id, classes_id))');
        $this->addSql('CREATE INDEX IDX_2D850A9C88185285 ON grade_category_classes (grade_category_id)');
        $this->addSql('CREATE INDEX IDX_2D850A9C9E225B24 ON grade_category_classes (classes_id)');
        $this->addSql('ALTER TABLE grade_category_classes ADD CONSTRAINT FK_2D850A9C88185285 FOREIGN KEY (grade_category_id) REFERENCES grade_category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE grade_category_classes ADD CONSTRAINT FK_2D850A9C9E225B24 FOREIGN KEY (classes_id) REFERENCES classes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE classes_grade_category');
        $this->addSql('DROP TABLE classes_gradecategories');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE classes_grade_category (classes_id INT NOT NULL, grade_category_id INT NOT NULL, PRIMARY KEY(classes_id, grade_category_id))');
        $this->addSql('CREATE INDEX idx_74a58a89e225b24 ON classes_grade_category (classes_id)');
        $this->addSql('CREATE INDEX idx_74a58a888185285 ON classes_grade_category (grade_category_id)');
        $this->addSql('CREATE TABLE classes_gradecategories (grade_category_id INT NOT NULL, classes_id INT NOT NULL, PRIMARY KEY(grade_category_id, classes_id))');
        $this->addSql('CREATE INDEX idx_430038c89e225b24 ON classes_gradecategories (classes_id)');
        $this->addSql('CREATE INDEX idx_430038c888185285 ON classes_gradecategories (grade_category_id)');
        $this->addSql('ALTER TABLE classes_grade_category ADD CONSTRAINT fk_74a58a89e225b24 FOREIGN KEY (classes_id) REFERENCES classes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE classes_grade_category ADD CONSTRAINT fk_74a58a888185285 FOREIGN KEY (grade_category_id) REFERENCES grade_category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE classes_gradecategories ADD CONSTRAINT fk_430038c888185285 FOREIGN KEY (grade_category_id) REFERENCES grade_category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE classes_gradecategories ADD CONSTRAINT fk_430038c89e225b24 FOREIGN KEY (classes_id) REFERENCES classes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE grade_category_classes');
    }
}
