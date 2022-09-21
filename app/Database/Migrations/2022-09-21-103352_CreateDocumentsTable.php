<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDocumentsTable extends Migration
{
    public function up()
    {
        // Drop table 'documents' if it exists
        $this->forge->dropTable('documents', true);

        // Table structure for table 'documents'
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
                'null' => true,
            ],
            'documentable_id' => [
                'type' => 'MEDIUMINT',
                'constraint' => '8',
                'null' => false,
            ],
            'documentable_type' => [
                'type' => 'VARCHAR',
                'constraint' => '191',
                'null' => false,
            ],
            'url' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '191',
                'null' => false,
            ],
            'extension' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
                'null' => false,
            ],
            'preview' => [
                'type' => 'VARCHAR',
                'constraint' => '191',
                'null' => true,
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => '191',
                'null' => false,
            ],
            'directory' => [
                'type' => 'VARCHAR',
                'constraint' => '191',
                'null' => true,
            ],
            'hash' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'size' => [
                'type' => 'BIGINT',
                'constraint' => '20',
                'unsigned' => true,
                'null' => false,
            ],
            'width' => [
                'type' => 'BIGINT',
                'constraint' => '20',
                'null' => true,
            ],
            'height' => [
                'type' => 'BIGINT',
                'constraint' => '20',
                'null' => true,
            ],
            'created_at timestamp default now()',
            'updated_at timestamp default now() on update now()',
            'deleted_at timestamp null',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'cascade', 'cascade');
        $this->forge->createTable('documents');
    }

    public function down()
    {
        $this->forge->dropTable('documents', true);
    }
}
