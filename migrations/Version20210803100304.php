<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210803100304 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subject DROP CONSTRAINT fk_fbce3e7a4a798b6f');
        $this->addSql('DROP SEQUENCE semester_id_seq CASCADE');
        $this->addSql('DROP TABLE semester');
        $this->addSql('DROP INDEX idx_fbce3e7a4a798b6f');
        $this->addSql('ALTER TABLE subject RENAME COLUMN semester_id TO year_of_study_id');
        $this->addSql('ALTER TABLE subject ADD CONSTRAINT FK_FBCE3E7A2A262BF9 FOREIGN KEY (year_of_study_id) REFERENCES year_of_study (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_FBCE3E7A2A262BF9 ON subject (year_of_study_id)');
        $this->addSql('ALTER TABLE year_of_study ADD is_active BOOLEAN DEFAULT \'false\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE semester_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE semester (id INT NOT NULL, year_of_study_id INT NOT NULL, semester INT NOT NULL, is_current BOOLEAN DEFAULT \'false\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_f7388eed2a262bf9 ON semester (year_of_study_id)');
        $this->addSql('ALTER TABLE semester ADD CONSTRAINT fk_f7388eed2a262bf9 FOREIGN KEY (year_of_study_id) REFERENCES year_of_study (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subject DROP CONSTRAINT FK_FBCE3E7A2A262BF9');
        $this->addSql('DROP INDEX IDX_FBCE3E7A2A262BF9');
        $this->addSql('ALTER TABLE subject RENAME COLUMN year_of_study_id TO semester_id');
        $this->addSql('ALTER TABLE subject ADD CONSTRAINT fk_fbce3e7a4a798b6f FOREIGN KEY (semester_id) REFERENCES semester (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_fbce3e7a4a798b6f ON subject (semester_id)');
        $this->addSql('ALTER TABLE year_of_study DROP is_active');
    }
}
