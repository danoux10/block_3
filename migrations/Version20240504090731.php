<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240504090731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE receipt (id INT AUTO_INCREMENT NOT NULL, contract_id INT NOT NULL, start_at DATE NOT NULL, end_at DATE NOT NULL, charge DOUBLE PRECISION NOT NULL, water DOUBLE PRECISION NOT NULL, electricity DOUBLE PRECISION NOT NULL, gas DOUBLE PRECISION NOT NULL, INDEX IDX_5399B6452576E0FD (contract_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE receipt ADD CONSTRAINT FK_5399B6452576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id)');
        $this->addSql('ALTER TABLE apartment ADD water DOUBLE PRECISION NOT NULL, ADD electricity DOUBLE PRECISION NOT NULL, ADD gas DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE receipt DROP FOREIGN KEY FK_5399B6452576E0FD');
        $this->addSql('DROP TABLE receipt');
        $this->addSql('ALTER TABLE apartment DROP water, DROP electricity, DROP gas');
    }
}
