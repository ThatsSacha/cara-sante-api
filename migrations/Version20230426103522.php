<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230426103522 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detection_test ADD already_invoiced_by_id INT DEFAULT NULL, ADD is_invoiced_on_amelipro TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE detection_test ADD CONSTRAINT FK_59AAD5FC9B6764E FOREIGN KEY (already_invoiced_by_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_59AAD5FC9B6764E ON detection_test (already_invoiced_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detection_test DROP FOREIGN KEY FK_59AAD5FC9B6764E');
        $this->addSql('DROP INDEX IDX_59AAD5FC9B6764E ON detection_test');
        $this->addSql('ALTER TABLE detection_test DROP already_invoiced_by_id, DROP is_invoiced_on_amelipro');
    }
}
