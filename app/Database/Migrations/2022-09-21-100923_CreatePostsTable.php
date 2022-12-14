<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePostsTable extends Migration
{
    public function up()
    {
        // Drop table 'posts' if it exists
        $this->forge->dropTable('posts', true);

        // Table structure for table 'posts'
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
            'post_id' => [
                'type' => 'BIGINT',
                'constraint' => '20',
                'null' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '191',
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => '191',
            ],
            'short_description' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'thumbnail' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['draft', 'pending', 'published'],
                'default' => 'draft',
            ],

            'views' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => '0',
            ],

            'published_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'meta' => [
                'type' => 'JSON',
                'null' => true,
            ],

            'created_at timestamp default now()',
            'updated_at timestamp default now() on update now()',
            'deleted_at timestamp null',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'cascade', 'cascade');
        $this->forge->addKey('slug');
        $this->forge->createTable('posts');
    }

    public function down()
    {
        $this->forge->dropTable('posts', true);
    }
}
