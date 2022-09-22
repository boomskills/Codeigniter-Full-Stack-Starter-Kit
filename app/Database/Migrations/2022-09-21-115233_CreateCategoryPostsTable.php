<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategoryPostsTable extends Migration
{
    public function up()
    {
        // Drop table 'category_posts' if it exists
        $this->forge->dropTable('category_posts', true);

        // Table structure for table 'category_posts'
        $this->forge->addField([
            'post_id' => [
                'type' => 'MEDIUMINT',
                'constraint' => '8',
                'unsigned' => true,
            ],

            'category_id' => [
                'type' => 'MEDIUMINT',
                'constraint' => '8',
                'unsigned' => true,
            ],
        ]);
        $this->forge->addPrimaryKey(['category_id', 'post_id']);
        $this->forge->addForeignKey('post_id', 'posts', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('category_posts');
    }

    public function down()
    {
        $this->forge->dropTable('category_posts', true);
    }
}
