<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePagesTable extends Migration
{
    public function up()
    {
        // Drop table 'pages' if it exists
        $this->forge->dropTable('pages', true);

        // Table structure for table 'pages'
        $this->forge->addField([
            'id' => [
                'type' => 'MEDIUMINT',
                'constraint' => '8',
                'unsigned' => true,
                'auto_increment' => true,
            ],

            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '191',
            ],

            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => '191',
            ],

            'content' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'created_at timestamp default now()',
            'updated_at timestamp default now() on update now()',
            'deleted_at timestamp null',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('slug');
        $this->forge->createTable('pages');
    }

    public function down()
    {
        $this->forge->dropTable('pages', true);
    }
}
