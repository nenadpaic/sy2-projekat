<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141006213915 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE Pictures (id INT AUTO_INCREMENT NOT NULL, galery_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_760A4D96DA40A005 (galery_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Pictures ADD CONSTRAINT FK_760A4D96DA40A005 FOREIGN KEY (galery_id) REFERENCES Galery (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('DROP TABLE Pictures');
    }
}
