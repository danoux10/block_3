<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240530193523 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE apartment (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, charge DOUBLE PRECISION NOT NULL, guarantee DOUBLE PRECISION NOT NULL, rent DOUBLE PRECISION NOT NULL, water DOUBLE PRECISION NOT NULL, electricity DOUBLE PRECISION NOT NULL, gas DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE apartment_owner (apartment_id INT NOT NULL, owner_id INT NOT NULL, INDEX IDX_88A7B5B1176DFE85 (apartment_id), INDEX IDX_88A7B5B17E3C61F9 (owner_id), PRIMARY KEY(apartment_id, owner_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contract (id INT AUTO_INCREMENT NOT NULL, apartment_id INT DEFAULT NULL, tenant_id INT DEFAULT NULL, type_payment_id INT DEFAULT NULL, start_at DATE NOT NULL, end_at DATE NOT NULL, INDEX IDX_E98F2859176DFE85 (apartment_id), INDEX IDX_E98F28599033212A (tenant_id), INDEX IDX_E98F285919C0759E (type_payment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventory (id INT AUTO_INCREMENT NOT NULL, apartment_id INT DEFAULT NULL, created_at DATE NOT NULL, remark LONGTEXT NOT NULL, INDEX IDX_B12D4A36176DFE85 (apartment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE owner (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, contract_id INT DEFAULT NULL, payment_type_id INT NOT NULL, created_at DATETIME NOT NULL, sum DOUBLE PRECISION NOT NULL, INDEX IDX_6D28840D2576E0FD (contract_id), INDEX IDX_6D28840DDC058279 (payment_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE receipt (id INT AUTO_INCREMENT NOT NULL, contract_id INT NOT NULL, start_at DATE NOT NULL, end_at DATE NOT NULL, charge DOUBLE PRECISION NOT NULL, water DOUBLE PRECISION NOT NULL, electricity DOUBLE PRECISION NOT NULL, gas DOUBLE PRECISION NOT NULL, INDEX IDX_5399B6452576E0FD (contract_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tenant (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, apl_value VARCHAR(255) DEFAULT NULL, apl TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE apartment_owner ADD CONSTRAINT FK_88A7B5B1176DFE85 FOREIGN KEY (apartment_id) REFERENCES apartment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apartment_owner ADD CONSTRAINT FK_88A7B5B17E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F2859176DFE85 FOREIGN KEY (apartment_id) REFERENCES apartment (id)');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F28599033212A FOREIGN KEY (tenant_id) REFERENCES tenant (id)');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F285919C0759E FOREIGN KEY (type_payment_id) REFERENCES payment_type (id)');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36176DFE85 FOREIGN KEY (apartment_id) REFERENCES apartment (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D2576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DDC058279 FOREIGN KEY (payment_type_id) REFERENCES payment_type (id)');
        $this->addSql('ALTER TABLE receipt ADD CONSTRAINT FK_5399B6452576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apartment_owner DROP FOREIGN KEY FK_88A7B5B1176DFE85');
        $this->addSql('ALTER TABLE apartment_owner DROP FOREIGN KEY FK_88A7B5B17E3C61F9');
        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F2859176DFE85');
        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F28599033212A');
        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F285919C0759E');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A36176DFE85');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D2576E0FD');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DDC058279');
        $this->addSql('ALTER TABLE receipt DROP FOREIGN KEY FK_5399B6452576E0FD');
        $this->addSql('DROP TABLE apartment');
        $this->addSql('DROP TABLE apartment_owner');
        $this->addSql('DROP TABLE contract');
        $this->addSql('DROP TABLE inventory');
        $this->addSql('DROP TABLE owner');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE payment_type');
        $this->addSql('DROP TABLE receipt');
        $this->addSql('DROP TABLE tenant');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
