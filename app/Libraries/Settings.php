<?php

namespace App\Libraries;

use Exception;

/**
 * Description of Settings.
 *
 * @author Geraldo Kandonga Fillipus fillipusgeraldo@gmail.com
 */
class Settings
{
    public $info = [];

    public function __construct()
    {
        $site = db_connect()->table('settings')->select(
            'site_title,
            site_heading,
            site_email,
            site_desc,
            meta_keywords,
            meta_description,
            facebook_url,
            twitter_url,
            youtube_url,
            instagram_url,
            client_layout,
            admin_layout,
            file_types,
            file_size,
            enable_google_analytic,
            default_role,
            google_analytic_key,
            google_recaptcha_key,
            google_recaptcha_secret,
            google_recaptcha,
            facebook_app_id,
            facebook_app_secret,
            facebook_call_back,
            google_client_id,
            google_client_secret,
            google_call_back,
            disable_social_login'
        )
            ->where('settings.id', 1)
            ->get();

        if (0 === count($site->getResultArray())) {
            throw new Exception('Something went wrong. Please try again later.');
        }
        $this->info = $site->getRow();
    }

    //--------------------------------------------------------------------
}
