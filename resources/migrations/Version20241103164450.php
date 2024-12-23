<?php

/** @noinspection PhpUnused */

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231105000001 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE accounts (
            id INT AUTO_INCREMENT NOT NULL,
            numero_conta INT NOT NULL,
            saldo FLOAT NOT NULL,
            UNIQUE INDEX UNIQ_ACCOUNT_NUMERO_CONTA (numero_conta),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE accounts');
    }
}
