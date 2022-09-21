<?php

namespace App\Models;

class SettingsModel extends BaseModel
{
    protected $table   = 'settings';
    protected $allowedFields    = [
        'site_title',
        'site_desc',
        'site_email',
        'site_heading',
        'meta_keywords',
        'meta_description',
        'client_layout',
        'admin_layout',
        'file_types',
        'file_size',
        'default_role',
        'facebook_url',
        'youtube_url',
        'twitter_url',
        'instagram_url',
        'enable_google_analytic',
        'google_analytic_key',
        'google_recaptcha_key',
        'google_recaptcha_secret',
        'google_recaptcha',
        'disable_captcha',
        'facebook_app_id',
        'facebook_app_secret',
        'facebook_call_back',
        'google_client_id',
        'google_client_secret',
        'google_call_back',
        'disable_social_login'

    ];
}
