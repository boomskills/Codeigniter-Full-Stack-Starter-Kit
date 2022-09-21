<?php

namespace Modules\Admin\Controllers;


use App\Repositories\UserRepository;

class DashboardController extends BaseAdminController
{
    protected $user_repo;

    public function __construct()
    {
        parent::__construct();
        $this->user_repo = new UserRepository();
    }

    public function index()
    {
        $this->data['panel_title'] = 'Dashboard';
        $this->data['users'] = $this->user_repo->totalUsers();
        $this->data['weekly_users'] = $this->user_repo->weeklyUsers();
        $this->data['recent_users'] = $this->user_repo->recentUsers();
        return $this->_render($this->admin->views['dashboard'], $this->data);
    }
}
