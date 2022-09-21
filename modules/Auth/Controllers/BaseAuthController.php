<?php

namespace Modules\Auth\Controllers;

use App\Controllers\BaseController;
use App\Models\NoticeModel;

class BaseAuthController extends BaseController
{
    protected $auth;

    /**
     * @var AuthConfig
     */
    protected $config;

    /**
     * @var Session
     */
    protected $session;

    public function __construct()
    {
        // required for authentication system
        $this->session = service('session');
        $this->config = config('Auth');
        $this->auth = service('authentication');

        // pre required for front end
        $this->settings = service('Settings');
        $this->data['head_title'] = $this->settings->info->site_title . ' | ' . $this->settings->info->site_heading;
        $this->data['meta_description'] = $this->settings->info->meta_description;
        $this->data['meta_keywords'] = $this->settings->info->meta_keywords;

        $this->data['rightLogo'] = $this->settings->info->header_logo_right;
        $this->data['leftIcon'] = $this->settings->info->header_logo_left;

        $this->data['facebook'] = $this->settings->info->facebook_url;
        $this->data['twitter'] = $this->settings->info->twitter_url;
        $this->data['instagram'] = $this->settings->info->instagram_url;
        $this->data['youtube'] = $this->settings->info->youtube_url;
        $this->data['config'] = $this->config;
        $this->data['notice'] = $this->notice();
    }

    protected function _render(string $view, array $data = [])
    {
        return view($view, $data);
    }

    /**
     * Load notice
     *
     */
    private function notice()
    {
        return (new NoticeModel())
            ->builder()
            ->where('start_at <', date('Y-m-d'))
            ->where('end_at >', date('Y-m-d'))
            ->where('active', 1)
            ->get(1)->getFirstRow();
    }
}
