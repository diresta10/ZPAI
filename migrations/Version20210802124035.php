<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210802124035 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE grade DROP CONSTRAINT FK_595AAE3412469DE2');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_595AAE3412469DE2 FOREIGN KEY (category_id) REFERENCES grade_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE grade DROP CONSTRAINT fk_595aae3412469de2');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT fk_595aae3412469de2 FOREIGN KEY (category_id) REFERENCES grade_category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
