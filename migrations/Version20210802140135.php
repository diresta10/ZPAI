<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210802140135 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subject ADD semester_id INT NOT NULL');
        $this->addSql('ALTER TABLE subject ADD CONSTRAINT FK_FBCE3E7A4A798B6F FOREIGN KEY (semester_id) REFERENCES semester (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_FBCE3E7A4A798B6F ON subject (semester_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE subject DROP CONSTRAINT FK_FBCE3E7A4A798B6F');
        $this->addSql('DROP INDEX IDX_FBCE3E7A4A798B6F');
        $this->addSql('ALTER TABLE subject DROP semester_id');
    }
}
