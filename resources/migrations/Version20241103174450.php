<?php

/** @noinspection PhpUnused */

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241103164450 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE transactions (
            id INT AUTO_INCREMENT NOT NULL,
            numero_conta INT NOT NULL,
            valor FLOAT NOT NULL,
            forma_pagamento VARCHAR(1) NOT NULL,
            saldo_apos_transacao FLOAT NOT NULL,
            INDEX IDX_TRANSACTION_NUMERO_CONTA (numero_conta),
            PRIMARY KEY(id),
            CONSTRAINT FK_ACCOUNT_TRANSACTION FOREIGN KEY (numero_conta) REFERENCES accounts (numero_conta) ON DELETE CASCADE
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE transactions');
    }
}
