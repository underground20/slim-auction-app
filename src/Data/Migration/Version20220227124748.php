<?php

declare(strict_types=1);

namespace App\Data\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220227124748 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create start schema tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE auth_user_networks (id UUID NOT NULL, user_id UUID NOT NULL, network_name VARCHAR(16) NOT NULL, network_identity VARCHAR(16) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3EA78C3BA76ED395 ON auth_user_networks (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3EA78C3B257EBD71C756D255 ON auth_user_networks (network_name, network_identity)');
        $this->addSql('COMMENT ON COLUMN auth_user_networks.user_id IS \'(DC2Type:auth_user_id)\'');
        $this->addSql('CREATE TABLE auth_users (user_id UUID NOT NULL, email VARCHAR(255) NOT NULL, password_hash VARCHAR(255) DEFAULT NULL, status INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, role VARCHAR(16) NOT NULL, join_confirm_token_value VARCHAR(255) DEFAULT NULL, join_confirm_token_expired_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, password_reset_token_value VARCHAR(255) DEFAULT NULL, password_reset_token_expired_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(user_id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D8A1F49CE7927C74 ON auth_users (email)');
        $this->addSql('COMMENT ON COLUMN auth_users.user_id IS \'(DC2Type:auth_user_id)\'');
        $this->addSql('COMMENT ON COLUMN auth_users.email IS \'(DC2Type:auth_user_email)\'');
        $this->addSql('COMMENT ON COLUMN auth_users.status IS \'(DC2Type:auth_user_status)\'');
        $this->addSql('COMMENT ON COLUMN auth_users.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN auth_users.role IS \'(DC2Type:auth_user_role)\'');
        $this->addSql('COMMENT ON COLUMN auth_users.join_confirm_token_expired_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN auth_users.password_reset_token_expired_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE auth_user_networks ADD CONSTRAINT FK_3EA78C3BA76ED395 FOREIGN KEY (user_id) REFERENCES auth_users (user_id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE auth_user_networks DROP CONSTRAINT FK_3EA78C3BA76ED395');
        $this->addSql('DROP TABLE auth_user_networks');
        $this->addSql('DROP TABLE auth_users');
    }
}
