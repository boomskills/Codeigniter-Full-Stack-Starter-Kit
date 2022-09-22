<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAuthsTableMigration extends Migration
{
    public function up()
    {
        $this->forge->dropTable('auths', true);
        $this->forge->dropTable('auth_logins', true);
        $this->forge->dropTable('auth_tokens', true);
        $this->forge->dropTable('auth_reset_attempts', true);
        $this->forge->dropTable('auth_activation_attempts', true);
        $this->forge->dropTable('roles', true);
        $this->forge->dropTable('permissions', true);
        $this->forge->dropTable('role_permissions', true);
        $this->forge->dropTable('role_users', true);
        $this->forge->dropTable('user_permissions', true);

        // authentications
        $this->forge->addField([
            'user_id' => ['type' => 'MEDIUMINT', 'constraint' => 8, 'unsigned' => true],
            'username' => ['type' => 'varchar', 'constraint' => 100],
            'password_hash' => ['type' => 'varchar', 'constraint' => 255],
            'reset_hash' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'reset_at' => ['type' => 'datetime', 'null' => true],
            'reset_expires' => ['type' => 'datetime', 'null' => true],
            'status' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'status_message' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'activate_hash' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'active' => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'activated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'force_pass_reset' => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
            ],
            'online_timestamp' => [
                'type' => 'BIGINT',
                'constraint' => '20',
                'null' => true,
            ],
            'created_at timestamp default now()',
            'updated_at timestamp default now() on update now()',
            'deleted_at timestamp null',
        ]);

        $this->forge->addKey('user_id', true);
        $this->forge->addUniqueKey('username');
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE', 'CASCADE');
        $this->forge->createTable('auths', true);

        // Auth Login Attempts
        $this->forge->addField([
            'id' => ['type' => 'MEDIUMINT', 'constraint' => 8, 'unsigned' => true, 'auto_increment' => true],
            'ip_address' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'username' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'user_id' => ['type' => 'MEDIUMINT', 'constraint' => 8, 'unsigned' => true, 'null' => true], // Only for successful logins
            'date' => ['type' => 'datetime'],
            'success' => ['type' => 'tinyint', 'constraint' => 1],
            'created_at timestamp default now()',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('username');
        $this->forge->addKey('user_id');
        $this->forge->createTable('auth_logins', true);

        /*
         * Auth Tokens
         * @see https://paragonie.com/blog/2015/04/secure-authentication-php-with-long-term-persistence
         */
        $this->forge->addField([
            'id' => ['type' => 'MEDIUMINT', 'constraint' => 8, 'unsigned' => true, 'auto_increment' => true],
            'selector' => ['type' => 'varchar', 'constraint' => 255],
            'hashedValidator' => ['type' => 'varchar', 'constraint' => 255],
            'user_id' => ['type' => 'MEDIUMINT', 'constraint' => 8, 'unsigned' => true],
            'expires' => ['type' => 'datetime'],
            'created_at timestamp default now()',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('selector');
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
        $this->forge->createTable('auth_tokens', true);

        // Password Reset Table
        $this->forge->addField([
            'id' => ['type' => 'MEDIUMINT', 'constraint' => 8, 'unsigned' => true, 'auto_increment' => true],
            'username' => ['type' => 'varchar', 'constraint' => 255],
            'ip_address' => ['type' => 'varchar', 'constraint' => 255],
            'user_agent' => ['type' => 'varchar', 'constraint' => 255],
            'token' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'created_at timestamp default now()',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auth_reset_attempts', true);

        // Activation Attempts Table
        $this->forge->addField([
            'id' => ['type' => 'MEDIUMINT', 'constraint' => 8, 'unsigned' => true, 'auto_increment' => true],
            'ip_address' => ['type' => 'varchar', 'constraint' => 255],
            'user_agent' => ['type' => 'varchar', 'constraint' => 255],
            'token' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'created_at timestamp default now()',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auth_activation_attempts', true);

        // Roles Table
        $fields = [
            'id' => ['type' => 'MEDIUMINT', 'constraint' => 8, 'unsigned' => true, 'auto_increment' => true],
            'name' => ['type' => 'varchar', 'constraint' => 255],
            'slug' => ['type' => 'varchar', 'constraint' => 255, 'unique' => true],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable('roles', true);

        // Permissions Table
        $fields = [
            'id' => ['type' => 'MEDIUMINT', 'constraint' => 8, 'unsigned' => true, 'auto_increment' => true],
            'name' => ['type' => 'varchar', 'constraint' => 255],
            'slug' => ['type' => 'varchar', 'constraint' => 255, 'unique' => true],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable('permissions', true);

        // Roles/Permissions Table
        $fields = [
            'role_id' => ['type' => 'MEDIUMINT', 'constraint' => 8, 'unsigned' => true, 'default' => 0],
            'permission_id' => ['type' => 'MEDIUMINT', 'constraint' => 8, 'unsigned' => true, 'default' => 0],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey(['role_id', 'permission_id']);
        $this->forge->addForeignKey('role_id', 'roles', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('permission_id', 'permissions', 'id', '', 'CASCADE');
        $this->forge->createTable('role_permissions', true);

        // Users/Role Table
        $fields = [
            'role_id' => ['type' => 'MEDIUMINT', 'constraint' => 8, 'unsigned' => true, 'default' => 0],
            'user_id' => ['type' => 'MEDIUMINT', 'constraint' => 8, 'unsigned' => true, 'default' => 0],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey(['role_id', 'user_id']);
        $this->forge->addForeignKey('role_id', 'roles', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
        $this->forge->createTable('role_users', true);

        // Users/Permissions Table
        $fields = [
            'user_id' => ['type' => 'MEDIUMINT', 'constraint' => 8, 'unsigned' => true, 'default' => 0],
            'permission_id' => ['type' => 'MEDIUMINT', 'constraint' => 8, 'unsigned' => true, 'default' => 0],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey(['user_id', 'permission_id']);
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('permission_id', 'permissions', 'id', '', 'CASCADE');
        $this->forge->createTable('user_permissions', true);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        // drop constraints first to prevent errors
        if ('SQLite3' != $this->db->DBDriver) { // @phpstan-ignore-line
            $this->forge->dropForeignKey('auth_tokens', 'auth_tokens_user_id_foreign');
            $this->forge->dropForeignKey('user_permissions', 'user_permissions_user_id_foreign');
            $this->forge->dropForeignKey('user_permissions', 'user_permissions_permission_id_foreign');
        }

        $this->forge->dropTable('auths', true);
        $this->forge->dropTable('auth_logins', true);
        $this->forge->dropTable('auth_tokens', true);
        $this->forge->dropTable('auth_reset_attempts', true);
        $this->forge->dropTable('auth_activation_attempts', true);
        $this->forge->dropTable('roles', true);
        $this->forge->dropTable('permissions', true);
        $this->forge->dropTable('role_permissions', true);
        $this->forge->dropTable('role_users', true);
        $this->forge->dropTable('user_permissions', true);
    }
}
