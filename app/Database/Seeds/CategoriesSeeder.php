<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        //$this->db->disableForeignKeyChecks();
        //$this->db->table('categories')->truncate();

        $this->db->table('categories')->insertBatch([
            [
                'slug' => 'news',
                'title' => 'News',
                'description' => ' News around running and fitness',
            ],
            [
                'slug' => 'blog',
                'title' => 'Blog',
                'description' => 'Blogs for the love of running',
            ],
            [
                'slug' => 'events',
                'title' => 'Events',
                'description' => 'Update on upcoming and next running challenges',
            ],
            [
                'slug' => 'announcement',
                'title' => 'Announcement',
                'description' => 'Announcements',
            ],
            [
                'slug' => 'sports',
                'title' => 'Sports',
                'description' => 'Sporting news and update',
            ],
        ]);
    }
}
