<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230427091118 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_export (id INT AUTO_INCREMENT NOT NULL, requested_by_id INT NOT NULL, data_from_id INT NOT NULL, requested_at DATETIME NOT NULL, file_path LONGTEXT NOT NULL, INDEX IDX_27DE0DA94DA1E751 (requested_by_id), INDEX IDX_27DE0DA91CC58FFA (data_from_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_export ADD CONSTRAINT FK_27DE0DA94DA1E751 FOREIGN KEY (requested_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE user_export ADD CONSTRAINT FK_27DE0DA91CC58FFA FOREIGN KEY (data_from_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_export DROP FOREIGN KEY FK_27DE0DA94DA1E751');
        $this->addSql('ALTER TABLE user_export DROP FOREIGN KEY FK_27DE0DA91CC58FFA');
        $this->addSql('DROP TABLE user_export');
    }
}
