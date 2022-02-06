<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210923203810 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cemetery_section DROP FOREIGN KEY FK_311AFB56EC636C87');
        $this->addSql('DROP INDEX IDX_311AFB56EC636C87 ON cemetery_section');
        $this->addSql('ALTER TABLE cemetery_section CHANGE cemetery_id cemetery_id BIGINT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cemetery_section CHANGE cemetery_id cemetery_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE cemetery_section ADD CONSTRAINT FK_311AFB56EC636C87 FOREIGN KEY (cemetery_id) REFERENCES cemetery (id)');
        $this->addSql('CREATE INDEX IDX_311AFB56EC636C87 ON cemetery_section (cemetery_id)');
    }
}
