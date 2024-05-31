<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240530062819 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE payment_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contract ADD type_payment_id INT NOT NULL');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F285919C0759E FOREIGN KEY (type_payment_id) REFERENCES payment_type (id)');
        $this->addSql('CREATE INDEX IDX_E98F285919C0759E ON contract (type_payment_id)');
        $this->addSql('ALTER TABLE payment ADD payment_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DDC058279 FOREIGN KEY (payment_type_id) REFERENCES payment_type (id)');
        $this->addSql('CREATE INDEX IDX_6D28840DDC058279 ON payment (payment_type_id)');
        $this->addSql('ALTER TABLE tenant CHANGE apl apl TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F285919C0759E');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DDC058279');
        $this->addSql('DROP TABLE payment_type');
        $this->addSql('DROP INDEX IDX_6D28840DDC058279 ON payment');
        $this->addSql('ALTER TABLE payment DROP payment_type_id');
        $this->addSql('DROP INDEX IDX_E98F285919C0759E ON contract');
        $this->addSql('ALTER TABLE contract DROP type_payment_id');
        $this->addSql('ALTER TABLE tenant CHANGE apl apl TINYINT(1) NOT NULL');
    }
}
