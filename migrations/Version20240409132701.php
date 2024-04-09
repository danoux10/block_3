<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240409132701 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE owner_apartment (owner_id INT NOT NULL, apartment_id INT NOT NULL, INDEX IDX_4F051BE77E3C61F9 (owner_id), INDEX IDX_4F051BE7176DFE85 (apartment_id), PRIMARY KEY(owner_id, apartment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE owner_apartment ADD CONSTRAINT FK_4F051BE77E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE owner_apartment ADD CONSTRAINT FK_4F051BE7176DFE85 FOREIGN KEY (apartment_id) REFERENCES apartment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apartment_owner DROP FOREIGN KEY FK_88A7B5B1176DFE85');
        $this->addSql('ALTER TABLE apartment_owner DROP FOREIGN KEY FK_88A7B5B17E3C61F9');
        $this->addSql('DROP TABLE apartment_owner');
        $this->addSql('ALTER TABLE contract ADD apartment_id INT DEFAULT NULL, ADD tenant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F2859176DFE85 FOREIGN KEY (apartment_id) REFERENCES apartment (id)');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F28599033212A FOREIGN KEY (tenant_id) REFERENCES tenant (id)');
        $this->addSql('CREATE INDEX IDX_E98F2859176DFE85 ON contract (apartment_id)');
        $this->addSql('CREATE INDEX IDX_E98F28599033212A ON contract (tenant_id)');
        $this->addSql('ALTER TABLE owner DROP lastname');
        $this->addSql('ALTER TABLE tenant CHANGE apl apl TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE apartment_owner (apartment_id INT NOT NULL, owner_id INT NOT NULL, INDEX IDX_88A7B5B1176DFE85 (apartment_id), INDEX IDX_88A7B5B17E3C61F9 (owner_id), PRIMARY KEY(apartment_id, owner_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE apartment_owner ADD CONSTRAINT FK_88A7B5B1176DFE85 FOREIGN KEY (apartment_id) REFERENCES apartment (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apartment_owner ADD CONSTRAINT FK_88A7B5B17E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE owner_apartment DROP FOREIGN KEY FK_4F051BE77E3C61F9');
        $this->addSql('ALTER TABLE owner_apartment DROP FOREIGN KEY FK_4F051BE7176DFE85');
        $this->addSql('DROP TABLE owner_apartment');
        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F2859176DFE85');
        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F28599033212A');
        $this->addSql('DROP INDEX IDX_E98F2859176DFE85 ON contract');
        $this->addSql('DROP INDEX IDX_E98F28599033212A ON contract');
        $this->addSql('ALTER TABLE contract DROP apartment_id, DROP tenant_id');
        $this->addSql('ALTER TABLE owner ADD lastname VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE tenant CHANGE apl apl TINYINT(1) DEFAULT NULL');
    }
}
