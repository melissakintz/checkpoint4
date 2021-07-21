<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210721080123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE compilation (id INT AUTO_INCREMENT NOT NULL, youtube_links LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', spotify_links LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', applemusic_links LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', description VARCHAR(255) DEFAULT NULL, title VARCHAR(255) NOT NULL, date DATE NOT NULL, private TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_compilation (user_id INT NOT NULL, compilation_id INT NOT NULL, INDEX IDX_4444467A76ED395 (user_id), INDEX IDX_4444467A5F8C840 (compilation_id), PRIMARY KEY(user_id, compilation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_compilation ADD CONSTRAINT FK_4444467A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_compilation ADD CONSTRAINT FK_4444467A5F8C840 FOREIGN KEY (compilation_id) REFERENCES compilation (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_compilation DROP FOREIGN KEY FK_4444467A5F8C840');
        $this->addSql('DROP TABLE compilation');
        $this->addSql('DROP TABLE user_compilation');
    }
}
