<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171008104839 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE job ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, DROP created_by, DROP updated_by');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F8B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F8896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_FBD8E0F8B03A8386 ON job (created_by_id)');
        $this->addSql('CREATE INDEX IDX_FBD8E0F8896DBBDE ON job (updated_by_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F8B03A8386');
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F8896DBBDE');
        $this->addSql('DROP INDEX IDX_FBD8E0F8B03A8386 ON job');
        $this->addSql('DROP INDEX IDX_FBD8E0F8896DBBDE ON job');
        $this->addSql('ALTER TABLE job ADD created_by VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD updated_by VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP created_by_id, DROP updated_by_id');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON DEFAULT NULL COMMENT \'(DC2Type:json)\'');
    }
}
