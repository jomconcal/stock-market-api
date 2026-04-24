<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260424194642 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add unique key symbol and latest_trading_day to global quote';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE global_quote DROP raw_response');
        $this->addSql('CREATE UNIQUE INDEX uniq_symbol_trading_day ON global_quote (symbol, latest_trading_day)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX uniq_symbol_trading_day ON global_quote');
        $this->addSql('ALTER TABLE global_quote ADD raw_response JSON NOT NULL');
    }
}
