<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260420211447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table global_quote';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE global_quote (id BINARY(16) NOT NULL, symbol VARCHAR(10) NOT NULL, open DOUBLE PRECISION NOT NULL, high DOUBLE PRECISION NOT NULL, low DOUBLE PRECISION NOT NULL, price DOUBLE PRECISION NOT NULL, volume INT NOT NULL, latest_trading_day VARCHAR(20) NOT NULL, previous_close DOUBLE PRECISION NOT NULL, `change` DOUBLE PRECISION NOT NULL, change_percent VARCHAR(10) NOT NULL, raw_response JSON NOT NULL, fetched_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE global_quote');
    }
}
