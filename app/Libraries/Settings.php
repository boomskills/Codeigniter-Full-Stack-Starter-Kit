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
            site_noreply_email,
            facebook_url,
            twitter_url,
            youtube_url,
            instagram_url,
            client_layout,
            admin_layout,
            file_types,
            file_size,
            default_user_role'
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
