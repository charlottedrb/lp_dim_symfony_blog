<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210316083357 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_9474526C4B89032C');
        $this->addSql('DROP INDEX IDX_9474526CF675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, author_id, post_id, content, created_at, is_deleted FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, post_id INTEGER NOT NULL, content CLOB NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, is_deleted BOOLEAN NOT NULL, CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9474526C4B89032C FOREIGN KEY (post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comment (id, author_id, post_id, content, created_at, is_deleted) SELECT id, author_id, post_id, content, created_at, is_deleted FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526C4B89032C ON comment (post_id)');
        $this->addSql('CREATE INDEX IDX_9474526CF675F31B ON comment (author_id)');
        $this->addSql('DROP INDEX IDX_5A8A6C8DF675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, author_id, content, created_at, is_published, is_deleted, title FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, content CLOB NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, is_published BOOLEAN NOT NULL, is_deleted BOOLEAN NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_5A8A6C8DF675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO post (id, author_id, content, created_at, is_published, is_deleted, title) SELECT id, author_id, content, created_at, is_published, is_deleted, title FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DF675F31B ON post (author_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, password FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, password VARCHAR(255) NOT NULL COLLATE BINARY, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        )');
        $this->addSql('INSERT INTO user (id, password) SELECT id, password FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_9474526CF675F31B');
        $this->addSql('DROP INDEX IDX_9474526C4B89032C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, author_id, post_id, content, created_at, is_deleted FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, post_id INTEGER NOT NULL, content CLOB NOT NULL, created_at DATETIME NOT NULL, is_deleted BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO comment (id, author_id, post_id, content, created_at, is_deleted) SELECT id, author_id, post_id, content, created_at, is_deleted FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526CF675F31B ON comment (author_id)');
        $this->addSql('CREATE INDEX IDX_9474526C4B89032C ON comment (post_id)');
        $this->addSql('DROP INDEX IDX_5A8A6C8DF675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, author_id, content, created_at, is_published, is_deleted, title FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, content CLOB NOT NULL, created_at DATETIME NOT NULL, is_published BOOLEAN NOT NULL, is_deleted BOOLEAN NOT NULL, title VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO post (id, author_id, content, created_at, is_published, is_deleted, title) SELECT id, author_id, content, created_at, is_published, is_deleted, title FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DF675F31B ON post (author_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, password FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL COLLATE BINARY, is_active BOOLEAN NOT NULL, is_blocked BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO user (id, password) SELECT id, password FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
    }
}
