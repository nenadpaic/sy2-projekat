<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141104123239 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE category_groups (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, group_id INT NOT NULL, INDEX IDX_FF85F30B12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groups (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, group_logo VARCHAR(255) DEFAULT NULL, group_cover VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, content_changed DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_F06D39705E237E06 (name), INDEX IDX_F06D3970A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_topics (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, group_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, content_changed DATETIME DEFAULT NULL, INDEX IDX_42709EE9A76ED395 (user_id), INDEX IDX_42709EE9FE54D947 (group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_topic_comments (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, topic_id INT DEFAULT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, content_changed DATETIME DEFAULT NULL, INDEX IDX_3122D25EA76ED395 (user_id), INDEX IDX_3122D25E1F55203D (topic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_topic_comments_replies (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, comment_id INT DEFAULT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, content_changed DATETIME DEFAULT NULL, INDEX IDX_7E9D40C4A76ED395 (user_id), INDEX IDX_7E9D40C4F8697D13 (comment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_users (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, group_id INT DEFAULT NULL, active INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, content_changed DATETIME DEFAULT NULL, INDEX IDX_44AF8E8EA76ED395 (user_id), INDEX IDX_44AF8E8EFE54D947 (group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Post (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Components (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_reports_actions (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_reports (id INT AUTO_INCREMENT NOT NULL, component INT DEFAULT NULL, reported_user_id INT DEFAULT NULL, user_reporting_id INT DEFAULT NULL, action_id INT DEFAULT NULL, component_id INT NOT NULL, component_name VARCHAR(255) NOT NULL, component_text LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, content_changed DATETIME DEFAULT NULL, INDEX IDX_A912B94F49FEA157 (component), INDEX IDX_A912B94FE7566E (reported_user_id), INDEX IDX_A912B94FA7227262 (user_reporting_id), INDEX IDX_A912B94F9D32F035 (action_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_groups ADD CONSTRAINT FK_FF85F30B12469DE2 FOREIGN KEY (category_id) REFERENCES Categories (id)');
        $this->addSql('ALTER TABLE groups ADD CONSTRAINT FK_F06D3970A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE group_topics ADD CONSTRAINT FK_42709EE9A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE group_topics ADD CONSTRAINT FK_42709EE9FE54D947 FOREIGN KEY (group_id) REFERENCES groups (id)');
        $this->addSql('ALTER TABLE group_topic_comments ADD CONSTRAINT FK_3122D25EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE group_topic_comments ADD CONSTRAINT FK_3122D25E1F55203D FOREIGN KEY (topic_id) REFERENCES group_topics (id)');
        $this->addSql('ALTER TABLE group_topic_comments_replies ADD CONSTRAINT FK_7E9D40C4A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE group_topic_comments_replies ADD CONSTRAINT FK_7E9D40C4F8697D13 FOREIGN KEY (comment_id) REFERENCES group_topic_comments (id)');
        $this->addSql('ALTER TABLE group_users ADD CONSTRAINT FK_44AF8E8EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE group_users ADD CONSTRAINT FK_44AF8E8EFE54D947 FOREIGN KEY (group_id) REFERENCES groups (id)');
        $this->addSql('ALTER TABLE user_reports ADD CONSTRAINT FK_A912B94F49FEA157 FOREIGN KEY (component) REFERENCES Components (id)');
        $this->addSql('ALTER TABLE user_reports ADD CONSTRAINT FK_A912B94FE7566E FOREIGN KEY (reported_user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE user_reports ADD CONSTRAINT FK_A912B94FA7227262 FOREIGN KEY (user_reporting_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE user_reports ADD CONSTRAINT FK_A912B94F9D32F035 FOREIGN KEY (action_id) REFERENCES user_reports_actions (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE group_topics DROP FOREIGN KEY FK_42709EE9FE54D947');
        $this->addSql('ALTER TABLE group_users DROP FOREIGN KEY FK_44AF8E8EFE54D947');
        $this->addSql('ALTER TABLE group_topic_comments DROP FOREIGN KEY FK_3122D25E1F55203D');
        $this->addSql('ALTER TABLE group_topic_comments_replies DROP FOREIGN KEY FK_7E9D40C4F8697D13');
        $this->addSql('ALTER TABLE category_groups DROP FOREIGN KEY FK_FF85F30B12469DE2');
        $this->addSql('ALTER TABLE user_reports DROP FOREIGN KEY FK_A912B94F49FEA157');
        $this->addSql('ALTER TABLE user_reports DROP FOREIGN KEY FK_A912B94F9D32F035');
        $this->addSql('DROP TABLE category_groups');
        $this->addSql('DROP TABLE groups');
        $this->addSql('DROP TABLE group_topics');
        $this->addSql('DROP TABLE group_topic_comments');
        $this->addSql('DROP TABLE group_topic_comments_replies');
        $this->addSql('DROP TABLE group_users');
        $this->addSql('DROP TABLE Post');
        $this->addSql('DROP TABLE Categories');
        $this->addSql('DROP TABLE Components');
        $this->addSql('DROP TABLE user_reports_actions');
        $this->addSql('DROP TABLE user_reports');
    }
}
