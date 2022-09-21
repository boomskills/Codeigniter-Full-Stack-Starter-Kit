<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'site_title' => 'Codeigniter Full-Stack Stater Kit',
            'site_heading' => 'Love for open source helps us build future technologies.',
            'site_email' => 'info@codeigniter-fullstack-starter-kit.com',
            'site_desc' => 'An awesome description of your beautiful website.',
            'meta_keywords' => 'php, codeigniter, blog, starter, template, open source',
            'facebook_url' => '#',
            'instagram_url' => '#',
            'client_layout' => 'layout\content',
            'admin_layout' => 'Modules\Admin\Views\layout\content',
            'file_size' => '1024',
            'disable_captcha' => 0,
            'default_role' => 3,
            'enable_google_analytic' => 0,
            'google_analytic_key' => "#",
            'google_recaptcha_key' => "#",
            'google_recaptcha_secret' => "#",
            'google_recaptcha' => "#",
            'facebook_app_id' => "#",
            'facebook_app_secret' => "#",
            'facebook_call_back' => "#",
            'google_client_id' => "#",
            'google_client_secret' => "#",
            'google_call_back' => "#",
            'disable_social_login' => '#'
        ];

        // Using Query Builder
        $this->db->table('settings')->insert($data);
    }
}
