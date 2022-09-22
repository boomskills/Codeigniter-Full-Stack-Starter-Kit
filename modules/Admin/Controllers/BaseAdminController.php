<?php

namespace Modules\Admin\Controllers;

use App\Libraries\User;
use App\Libraries\Factory;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use App\Utils\Traits\SavesDocuments;

class BaseAdminController extends BaseController
{
    use ResponseTrait;
    use SavesDocuments;
    public $data;
    protected $admin;
    protected $template;
    protected $auth;
    protected $user;
    protected $factory;

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
        helper(['url', 'html', 'url', 'form', 'common']);
        $this->session = service('session');
        $this->config = config('Auth');
        $this->auth = service('authentication');
        $this->admin = config('Admin');
        $this->template = config('Template');
        $this->data['panel_title'] = 'Dashboard';
        $this->data['admin'] = $this->admin;
        $this->data['settings'] = service('settings');
        $this->factory = new Factory();

        // is user logged in
        if (logged_in()) {
            $this->data['user'] = new User(auth_id());
            $this->user = $this->data['user'];
        }
    }

    protected function _render(string $view, array $data = [])
    {
        return view($view, $data);
    }
}
