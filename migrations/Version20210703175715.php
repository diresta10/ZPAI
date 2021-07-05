<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210703175715 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE grade_category ADD classes_id INT NOT NULL');
        $this->addSql('ALTER TABLE grade_category ADD CONSTRAINT FK_48B2D7079E225B24 FOREIGN KEY (classes_id) REFERENCES classes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_48B2D7079E225B24 ON grade_category (classes_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE grade_category DROP CONSTRAINT FK_48B2D7079E225B24');
        $this->addSql('DROP INDEX IDX_48B2D7079E225B24');
        $this->addSql('ALTER TABLE grade_category DROP classes_id');
    }
}
