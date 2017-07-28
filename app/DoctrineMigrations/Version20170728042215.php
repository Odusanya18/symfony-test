<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170728042215 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE films (id INT AUTO_INCREMENT NOT NULL, country INT DEFAULT NULL, genre INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description MEDIUMTEXT NOT NULL, release_date DATE NOT NULL, rating INT NOT NULL, ticket_price NUMERIC(10, 2) NOT NULL, INDEX IDX_CEECCA515373C966 (country), INDEX IDX_CEECCA51835033F8 (genre), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, film_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, comment VARCHAR(500) NOT NULL, INDEX IDX_5F9E962A567F5183 (film_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE accounts (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, plain_password VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', salt VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE films ADD CONSTRAINT FK_CEECCA515373C966 FOREIGN KEY (country) REFERENCES country (id)');
        $this->addSql('ALTER TABLE films ADD CONSTRAINT FK_CEECCA51835033F8 FOREIGN KEY (genre) REFERENCES genre (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A567F5183 FOREIGN KEY (film_id) REFERENCES films (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A567F5183');
        $this->addSql('ALTER TABLE films DROP FOREIGN KEY FK_CEECCA515373C966');
        $this->addSql('ALTER TABLE films DROP FOREIGN KEY FK_CEECCA51835033F8');
        $this->addSql('DROP TABLE films');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE accounts');
    }
}
