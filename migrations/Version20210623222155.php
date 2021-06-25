<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210623222155 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classes DROP CONSTRAINT fk_2ed7ec5fe54d947');
        $this->addSql('DROP INDEX idx_2ed7ec5fe54d947');
        $this->addSql('ALTER TABLE classes DROP group_id');
        $this->addSql('ALTER TABLE subject ADD group_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE subject ADD CONSTRAINT FK_FBCE3E7AFE54D947 FOREIGN KEY (group_id) REFERENCES "sgroup" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_FBCE3E7AFE54D947 ON subject (group_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE classes ADD group_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE classes ADD CONSTRAINT fk_2ed7ec5fe54d947 FOREIGN KEY (group_id) REFERENCES sgroup (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_2ed7ec5fe54d947 ON classes (group_id)');
        $this->addSql('ALTER TABLE subject DROP CONSTRAINT FK_FBCE3E7AFE54D947');
        $this->addSql('DROP INDEX IDX_FBCE3E7AFE54D947');
        $this->addSql('ALTER TABLE subject DROP group_id');
    }
}
