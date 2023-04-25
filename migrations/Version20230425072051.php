<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230425072051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE detection_test (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, patient_id INT NOT NULL, updating_by_id INT DEFAULT NULL, tested_at DATETIME NOT NULL, is_invoiced TINYINT(1) NOT NULL, filled_at DATETIME DEFAULT NULL, ref VARCHAR(255) NOT NULL, is_updating TINYINT(1) NOT NULL, is_negative TINYINT(1) DEFAULT NULL, start_updating DATETIME DEFAULT NULL, doctor_first_name VARCHAR(255) DEFAULT NULL, doctor_last_name VARCHAR(255) DEFAULT NULL, INDEX IDX_59AAD5FA76ED395 (user_id), INDEX IDX_59AAD5F6B899279 (patient_id), INDEX IDX_59AAD5FAA827920 (updating_by_id), INDEX IDX_59AAD5F146F3EA3 (ref), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, mail VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, birth DATE DEFAULT NULL, street VARCHAR(255) DEFAULT NULL, zip VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, nir VARCHAR(255) NOT NULL, ref VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE search (id INT AUTO_INCREMENT NOT NULL, searched_by_id INT NOT NULL, searched_at DATETIME NOT NULL, subject VARCHAR(255) NOT NULL, INDEX IDX_B4F0DBA7EA547A9C (searched_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, desactivated_by_id INT DEFAULT NULL, email VARCHAR(180) DEFAULT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, phone VARCHAR(255) DEFAULT NULL, is_first_connection TINYINT(1) NOT NULL, token VARCHAR(255) DEFAULT NULL, ref VARCHAR(255) NOT NULL, is_desactivated TINYINT(1) NOT NULL, desactivated_at DATETIME DEFAULT NULL, last_login DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), INDEX IDX_1483A5E9B03A8386 (created_by_id), INDEX IDX_1483A5E9CD40D635 (desactivated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE detection_test ADD CONSTRAINT FK_59AAD5FA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE detection_test ADD CONSTRAINT FK_59AAD5F6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE detection_test ADD CONSTRAINT FK_59AAD5FAA827920 FOREIGN KEY (updating_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE search ADD CONSTRAINT FK_B4F0DBA7EA547A9C FOREIGN KEY (searched_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9CD40D635 FOREIGN KEY (desactivated_by_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detection_test DROP FOREIGN KEY FK_59AAD5FA76ED395');
        $this->addSql('ALTER TABLE detection_test DROP FOREIGN KEY FK_59AAD5F6B899279');
        $this->addSql('ALTER TABLE detection_test DROP FOREIGN KEY FK_59AAD5FAA827920');
        $this->addSql('ALTER TABLE search DROP FOREIGN KEY FK_B4F0DBA7EA547A9C');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9B03A8386');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9CD40D635');
        $this->addSql('DROP TABLE detection_test');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE search');
        $this->addSql('DROP TABLE users');
    }
}
