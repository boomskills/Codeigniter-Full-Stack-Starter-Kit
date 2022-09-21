<?php

namespace Modules\Admin\Controllers;

use Modules\Auth\Authorization\PermissionModel as Permission;

class PermissionController extends BaseAdminController
{
    protected $permission;

    public function __construct()
    {
        parent::__construct();
        $this->permission = new Permission();
    }

    /**
     * /**
     * Display a listing resources.
     *
     * @return mixed
     */
    public function index()
    {
        $this->data['panel_title'] = 'Permissions';
        $this->data['permissions'] = $this->permission->findAll();
        return $this->_render($this->admin->views['role']['permissions'], $this->data);
    }
}
