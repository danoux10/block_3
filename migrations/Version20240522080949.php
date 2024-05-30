<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240522080949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F285919C0759E');
        $this->addSql('DROP INDEX IDX_E98F2859C54C8C93 ON contract');
        $this->addSql('ALTER TABLE contract CHANGE type_id type_payment_id INT NOT NULL');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F285919C0759E FOREIGN KEY (type_payment_id) REFERENCES payment_type (id)');
        $this->addSql('CREATE INDEX IDX_E98F285919C0759E ON contract (type_payment_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F285919C0759E');
        $this->addSql('DROP INDEX IDX_E98F285919C0759E ON contract');
        $this->addSql('ALTER TABLE contract CHANGE type_payment_id type_id INT NOT NULL');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F285919C0759E FOREIGN KEY (type_id) REFERENCES payment_type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_E98F2859C54C8C93 ON contract (type_id)');
    }
}
