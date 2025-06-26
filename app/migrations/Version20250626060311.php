<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250626060311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE TABLE sms_log (id SERIAL NOT NULL, user_id INT NOT NULL, message VARCHAR(255) NOT NULL, sent_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_A9E43D70A76ED395 ON sms_log (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sms_log ADD CONSTRAINT FK_A9E43D70A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            ALTER TABLE sms_log DROP CONSTRAINT FK_A9E43D70A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE sms_log
        SQL);
    }
}
