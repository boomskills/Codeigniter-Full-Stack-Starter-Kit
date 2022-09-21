<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAccountsTable extends Migration
{
    public function up()
    {
        // Drop table 'accounts' if it exists
        $this->forge->dropTable('accounts', true);

        // Table structure for table 'accounts'
        $this->forge->addField([
            'id' => [
                'type' => 'MEDIUMINT',
                'constraint' => '8',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'MEDIUMINT',
                'constraint' => '8',
                'unsigned' => true,
            ],

            'account_number' => [
                'type' => 'VARCHAR',
                'constraint' => '254',
            ],

            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '254',
            ],

            'created_at timestamp default now()',
            'updated_at timestamp default now() on update now()',
            'deleted_at timestamp null',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'cascade', 'cascade');
        $this->forge->addKey('user_id');
        $this->forge->createTable('accounts');
    }

    public function down()
    {
        $this->forge->dropTable('accounts', true);
    }
}
