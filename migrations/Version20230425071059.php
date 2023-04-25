<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230425071059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE test');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE test (invoiced_by_first_name TEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, invoiced_by_last_name TEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, nom prenom TEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, nir TEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, birth TEXT CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, antigenic_date TEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, doctor_first_name TEXT CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, doctor_last_name TEXT CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, medical_center TEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
    }
}
