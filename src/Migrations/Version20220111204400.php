<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220111204400 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE burial ADD full_name VARCHAR(255) NOT NULL, ADD birth_date DATE DEFAULT NULL, ADD birth_year SMALLINT NOT NULL, ADD death_date DATE DEFAULT NULL, ADD death_year SMALLINT NOT NULL, ADD age SMALLINT NOT NULL, ADD burial_type_name VARCHAR(255) NOT NULL, ADD section_name VARCHAR(255) NOT NULL, ADD alley_name VARCHAR(255) NOT NULL, ADD cemetery_name VARCHAR(255) NOT NULL, ADD photo_path1 VARCHAR(255) NOT NULL, ADD photo_path2 VARCHAR(255) NOT NULL, ADD last_modified DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, DROP birthdate, DROP death, CHANGE created created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE burial ADD birthdate DATE DEFAULT NULL, ADD death DATE DEFAULT NULL, DROP full_name, DROP birth_date, DROP birth_year, DROP death_date, DROP death_year, DROP age, DROP burial_type_name, DROP section_name, DROP alley_name, DROP cemetery_name, DROP photo_path1, DROP photo_path2, DROP last_modified, CHANGE created_at created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }
}
