<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220207000521 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE icon (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE system_parameter (id BIGINT AUTO_INCREMENT NOT NULL, token VARCHAR(255) NOT NULL, INDEX token (token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP INDEX names_cemetery ON burial');
        $this->addSql('DROP INDEX cemetery_name ON burial');
        $this->addSql('DROP INDEX names ON burial');
        $this->addSql('DROP INDEX first_name ON burial');
        $this->addSql('DROP INDEX last_name ON burial');
        $this->addSql('DROP INDEX middle_name ON burial');
        $this->addSql('CREATE INDEX names_cemetery ON burial (last_name(40), first_name(40), middle_name(40), cemetery_name(40))');
        $this->addSql('CREATE INDEX cemetery_name ON burial (cemetery_name(40))');
        $this->addSql('CREATE INDEX names ON burial (last_name(40), first_name(40), middle_name(40))');
        $this->addSql('CREATE INDEX first_name ON burial (first_name(40))');
        $this->addSql('CREATE INDEX last_name ON burial (last_name(40))');
        $this->addSql('CREATE INDEX middle_name ON burial (middle_name(40))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE icon');
        $this->addSql('DROP TABLE system_parameter');
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
