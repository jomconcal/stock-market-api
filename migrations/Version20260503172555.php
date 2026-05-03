<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260503172555 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE global_quote (id BINARY(16) NOT NULL, fetched_at DATETIME NOT NULL, symbol VARCHAR(10) NOT NULL, current_price DOUBLE PRECISION NOT NULL, price_change DOUBLE PRECISION NOT NULL, change_percent DOUBLE PRECISION NOT NULL, high DOUBLE PRECISION NOT NULL, low DOUBLE PRECISION NOT NULL, open DOUBLE PRECISION NOT NULL, previous_close DOUBLE PRECISION NOT NULL, last_update DATETIME NOT NULL, UNIQUE INDEX uniq_symbol_last_update (symbol, last_update), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE global_quote');
    }
}
