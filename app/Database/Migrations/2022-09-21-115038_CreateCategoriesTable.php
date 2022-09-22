<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        // Drop table 'categories' if it exists
        $this->forge->dropTable('categories', true);

        // Table structure for table 'categories'
        $this->forge->addField([
            'id' => [
                'type' => 'MEDIUMINT',
                'constraint' => '8',
                'unsigned' => true,
                'auto_increment' => true,
            ],

            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => '191',
                'unique' => true,
            ],

            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '191',
            ],

            'description' => [
                'type' => 'MEDIUMTEXT',
                'null' => true,
            ],

            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => '191',
                'null' => true,
            ],

            'active' => [
                "type" => "TINYINT",
                'constraint' => '1',
                'default' => 0
            ],

            'created_at timestamp default now()',
            'updated_at timestamp default now() on update now()',
            'deleted_at timestamp null',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('categories');
    }

    public function down()
    {
        $this->forge->dropTable('categories', true);
    }
}
