<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220205183229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE additional ADD price_string VARCHAR(255) NOT NULL, ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD last_modified DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, DROP price, DROP text, CHANGE image additional VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX last_name ON burial');
        $this->addSql('DROP INDEX cemetery_name ON burial');
        $this->addSql('DROP INDEX middle_name ON burial');
        $this->addSql('DROP INDEX first_name ON burial');
        $this->addSql('DROP INDEX names_cemetery ON burial');
        $this->addSql('DROP INDEX names ON burial');
        $this->addSql('CREATE INDEX last_name ON burial (last_name(40))');
        $this->addSql('CREATE INDEX cemetery_name ON burial (cemetery_name(40))');
        $this->addSql('CREATE INDEX middle_name ON burial (middle_name(40))');
        $this->addSql('CREATE INDEX first_name ON burial (first_name(40))');
        $this->addSql('CREATE INDEX names_cemetery ON burial (last_name(40), first_name(40), middle_name(40), cemetery_name(40))');
        $this->addSql('CREATE INDEX names ON burial (last_name(40), first_name(40), middle_name(40))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE additional ADD image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD price NUMERIC(20, 2) NOT NULL, ADD text LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP additional, DROP price_string, DROP created_at, DROP last_modified');
        $this->addSql('DROP INDEX last_name ON burial');
        $this->addSql('DROP INDEX first_name ON burial');
        $this->addSql('DROP INDEX middle_name ON burial');
        $this->addSql('DROP INDEX cemetery_name ON burial');
        $this->addSql('DROP INDEX names ON burial');
        $this->addSql('DROP INDEX names_cemetery ON burial');
        $this->addSql('CREATE INDEX last_name ON burial (last_name(40))');
        $this->addSql('CREATE INDEX first_name ON burial (first_name(40))');
        $this->addSql('CREATE INDEX middle_name ON burial (middle_name(40))');
        $this->addSql('CREATE INDEX cemetery_name ON burial (cemetery_name(40))');
        $this->addSql('CREATE INDEX names ON burial (last_name(40), first_name(40), middle_name(40))');
        $this->addSql('CREATE INDEX names_cemetery ON burial (last_name(40), first_name(40), middle_name(40), cemetery_name(40))');
    }
}
