<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200114200751 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article CHANGE rating rating INT DEFAULT NULL, CHANGE number_of_views number_of_views INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE comment CHANGE comment_id comment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE continent DROP image, DROP content');
        $this->addSql('ALTER TABLE country DROP image, DROP content');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE is_allowed_to_post is_allowed_to_post TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article CHANGE rating rating INT DEFAULT NULL, CHANGE number_of_views number_of_views INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category DROP slug');
        $this->addSql('ALTER TABLE comment CHANGE comment_id comment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE continent ADD image LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, ADD content LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`');
        $this->addSql('ALTER TABLE country ADD image LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, ADD content LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`');
        $this->addSql('ALTER TABLE user CHANGE is_allowed_to_post is_allowed_to_post TINYINT(1) DEFAULT \'NULL\', CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
