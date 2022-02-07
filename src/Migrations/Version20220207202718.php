<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220207202718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX middle_name ON burial');
        $this->addSql('DROP INDEX first_name ON burial');
        $this->addSql('DROP INDEX names_cemetery ON burial');
        $this->addSql('DROP INDEX names ON burial');
        $this->addSql('DROP INDEX cemetery_name ON burial');
        $this->addSql('DROP INDEX last_name ON burial');
        $this->addSql('ALTER TABLE burial CHANGE latitude latitude NUMERIC(15, 12) DEFAULT \'0\' NOT NULL, CHANGE longitude longitude NUMERIC(15, 12) DEFAULT \'0\' NOT NULL');
        $this->addSql('CREATE INDEX middle_name ON burial (middle_name(40))');
        $this->addSql('CREATE INDEX first_name ON burial (first_name(40))');
        $this->addSql('CREATE INDEX names_cemetery ON burial (last_name(40), first_name(40), middle_name(40), cemetery_name(40))');
        $this->addSql('CREATE INDEX names ON burial (last_name(40), first_name(40), middle_name(40))');
        $this->addSql('CREATE INDEX cemetery_name ON burial (cemetery_name(40))');
        $this->addSql('CREATE INDEX last_name ON burial (last_name(40))');
        $this->addSql('ALTER TABLE city CHANGE latitude latitude NUMERIC(10, 6) DEFAULT \'0\' NOT NULL, CHANGE longitude longitude NUMERIC(10, 6) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE desktop_entry CHANGE id id BIGINT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE file CHANGE latitude latitude NUMERIC(15, 12) DEFAULT \'0\' NOT NULL, CHANGE longitude longitude NUMERIC(15, 12) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE system_parameter ADD string_value VARCHAR(255) NOT NULL, ADD text_value LONGTEXT NOT NULL, ADD numeric_value INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE additional CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE additional additional VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE html_title html_title VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE meta_description meta_description LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE meta_keywords meta_keywords LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE price_string price_string VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE additional_section CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE text text LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE adjacency_list CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE admin CHANGE username username VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE bind_contained CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE bind_container CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX last_name ON burial');
        $this->addSql('DROP INDEX first_name ON burial');
        $this->addSql('DROP INDEX middle_name ON burial');
        $this->addSql('DROP INDEX cemetery_name ON burial');
        $this->addSql('DROP INDEX names ON burial');
        $this->addSql('DROP INDEX names_cemetery ON burial');
        $this->addSql('ALTER TABLE burial CHANGE first_name first_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE middle_name middle_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE last_name last_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE full_name full_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE obituary obituary LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE burial_type_name burial_type_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE section_name section_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE alley_name alley_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE cemetery_name cemetery_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE latitude latitude NUMERIC(15, 12) DEFAULT \'0.000000000000\' NOT NULL, CHANGE longitude longitude NUMERIC(15, 12) DEFAULT \'0.000000000000\' NOT NULL, CHANGE photo_path1 photo_path1 VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE photo_path2 photo_path2 VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE INDEX last_name ON burial (last_name(40))');
        $this->addSql('CREATE INDEX first_name ON burial (first_name(40))');
        $this->addSql('CREATE INDEX middle_name ON burial (middle_name(40))');
        $this->addSql('CREATE INDEX cemetery_name ON burial (cemetery_name(40))');
        $this->addSql('CREATE INDEX names ON burial (last_name(40), first_name(40), middle_name(40))');
        $this->addSql('CREATE INDEX names_cemetery ON burial (last_name(40), first_name(40), middle_name(40), cemetery_name(40))');
        $this->addSql('ALTER TABLE care CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE additional additional VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE html_title html_title VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE meta_description meta_description LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE meta_keywords meta_keywords LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE price_string price_string VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE text text LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE care_section CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE cemetery CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE address address VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE phone phone VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE cemetery_section CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE label label VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE label_tmp label_tmp VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE number number VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE city CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE name_en name_en VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE latitude latitude NUMERIC(10, 6) DEFAULT \'0.000000\' NOT NULL, CHANGE longitude longitude NUMERIC(10, 6) DEFAULT \'0.000000\' NOT NULL, CHANGE okato okato CHAR(20) DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE subdomain subdomain VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE comment CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE comment comment LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE user_agent user_agent VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE ip_address ip_address VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE object_type object_type VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE desktop_entry CHANGE id id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE url url VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE eval_script eval_script LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE icon icon VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE feedback_form CHANGE client client VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE phone phone VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE message message LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE fields_example CHANGE textarea textarea VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image2 image2 VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE text text LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE file CHANGE filename filename VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE module module VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE type type VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE latitude latitude NUMERIC(15, 12) DEFAULT \'0.000000000000\' NOT NULL, CHANGE longitude longitude NUMERIC(15, 12) DEFAULT \'0.000000000000\' NOT NULL');
        $this->addSql('ALTER TABLE flowers CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE additional additional VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE article article VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE size size VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image1 image1 VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE thumbnail1 thumbnail1 VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image2 image2 VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE thumbnail2 thumbnail2 VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image3 image3 VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE thumbnail3 thumbnail3 VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image4 image4 VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE thumbnail4 thumbnail4 VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE html_title html_title VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE meta_description meta_description LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE meta_keywords meta_keywords LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE price_string price_string VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE flowers_section CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE history_upload_image CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE path path VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE thumbnail thumbnail VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE icon CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE code code VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE icon_style_class icon_style_class VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE image CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE source source VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE source_url source_url VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE alt alt LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE interesting CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image1 image1 VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image2 image2 VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE text1 text1 LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE text2 text2 LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE html_title html_title VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE meta_description meta_description LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE meta_keywords meta_keywords LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE source source VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE source_url source_url VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE named_timestampable CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE text text LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE news CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image1 image1 VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image2 image2 VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE text1 text1 LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE text2 text2 LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE html_title html_title VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE meta_description meta_description LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE meta_keywords meta_keywords LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE source source VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE source_url source_url VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE obituary_form CHANGE dead dead VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE obituary obituary LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE order_form CHANGE client client VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE dead dead VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE phone phone VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE service service VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE messenger messenger VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE order_passport CHANGE client client VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE phone phone VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE dead dead VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE organization CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE parameter CHANGE code code VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE text text LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE textarea textarea VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE picture CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image1 image1 VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image2 image2 VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE text1 text1 LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE text2 text2 LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE html_title html_title VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE meta_description meta_description LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE meta_keywords meta_keywords LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE source source VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE source_url source_url VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE review CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE comment comment LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE ip_address ip_address VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE section CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE html_title html_title VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE text text LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE meta_description meta_description LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE meta_keywords meta_keywords LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE code code VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE slider_image CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE text text LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE slider_text CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE text text LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE system_parameter DROP string_value, DROP text_value, DROP numeric_value, CHANGE token token VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE text_block CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE text text LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE html_title html_title VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE meta_description meta_description LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE meta_keywords meta_keywords LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE code code VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE text_page CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE text text LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE html_title html_title VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE meta_description meta_description LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE meta_keywords meta_keywords LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE slug slug VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE signature signature LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE avatar avatar VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user_files CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE filename filename VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE content_type content_type VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
