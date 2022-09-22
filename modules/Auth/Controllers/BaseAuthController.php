<?php

namespace Modules\Auth\Controllers;

use App\Controllers\BaseController;

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
        $this->data['config'] = $this->config;
    }

    protected function _render(string $view, array $data = [])
    {
        return view($view, $data);
    }
}
