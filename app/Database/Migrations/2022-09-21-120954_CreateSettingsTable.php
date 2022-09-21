<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        // Drop table 'users' if it exists
        $this->forge->dropTable('settings', true);

        // Table structure for table 'users'
        $this->forge->addField([
            'id' => [
                'type' => 'MEDIUMINT',
                'constraint' => '8',
                'unsigned' => true,
                'auto_increment' => true,
            ],

            'site_title' => [
                'type' => 'VARCHAR',
                'constraint' => '191',
                'null' => true,
            ],

            'site_heading' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],

            'site_email' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],

            'site_desc' => [
                'type' => 'MEDIUMTEXT',
                'null' => true,
            ],

            'meta_keywords' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],

            'meta_description' => [
                'type' => 'VARCHAR',
                'constraint' => '350',
                'null' => true,
            ],


            'facebook_url' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],

            'twitter_url' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],

            'youtube_url' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],

            'instagram_url' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],

            'client_layout' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],

            'admin_layout' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],

            'file_types' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],

            'disable_social_login' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'default' => 0,
            ],

            'facebook_app_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],

            'facebook_app_secret' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],

            'facebook_call_back' => [
                'type' => 'VARCHAR',
                'constraint' => '550',
                'null' => true,
            ],

            'google_client_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],

            'google_client_secret' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],

            'google_call_back' => [
                'type' => 'VARCHAR',
                'constraint' => '550',
                'null' => true,
            ],

            'file_size' => [
                'type' => 'INT',
                'constraint' => '11',
                'default' => 0,
            ],

            'default_role' => [
                'type' => 'MEDIUMINT',
                'constraint' => '8',
                'null' => true,
            ],

            'disable_captcha' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'default' => 0,
            ],

            'google_recaptcha' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],

            'google_recaptcha_secret' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],

            'google_recaptcha_key' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],

            'google_analytic_key' => [
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
            ],

            'enable_google_analytic' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'default' => 0,
            ],

            'created_at timestamp default now()',
            'updated_at timestamp default now() on update now()',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('settings');
    }

    public function down()
    {
        $this->forge->dropTable('settings', true);
    }
}
