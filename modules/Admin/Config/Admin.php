<?php

namespace Modules\Admin\Config;

use CodeIgniter\Config\BaseConfig;

class Admin extends BaseConfig
{
    /**
     * --------------------------------------------------------------------
     * Layout for the views to extend
     * --------------------------------------------------------------------.
     *
     * @var string
     */
    public $viewLayout = 'Modules\Admin\Views\layout\content';

    /**
     * --------------------------------------------------------------------
     * Views used by Admin Controllers
     * --------------------------------------------------------------------.
     *
     * @var array
     */
    public $views = [
        'dashboard' => 'Modules\Admin\Views\dashboard',
        'site_setting' => 'Modules\Admin\Views\setting\index',

        'category' => [
            'index' => 'Modules\Admin\Views\category\index',
            'new' => 'Modules\Admin\Views\category\new',
            'edit' => 'Modules\Admin\Views\category\edit',
        ],

        'page' => [
            'index' => 'Modules\Admin\Views\page\index',
            'new' => 'Modules\Admin\Views\page\new',
            'edit' => 'Modules\Admin\Views\page\edit',
        ],

        'user' => [
            'index' => 'Modules\Admin\Views\user\index',
            'edit' => 'Modules\Admin\Views\user\edit',
            'wallet' => 'Modules\Admin\Views\user\wallet',
        ],

        'post' => [
            'index' => 'Modules\Admin\Views\post\index',
            'edit' => 'Modules\Admin\Views\post\edit',
            'new' => 'Modules\Admin\Views\post\new',
        ],

        'role' => [
            'new_role' => 'Modules\Admin\Views\role\new_role',
            'edit_role' => 'Modules\Admin\Views\role\edit_role',
            'index' => 'Modules\Admin\Views\role\index',
            'permissions' => 'Modules\Admin\Views\role\permissions',
        ],

    ];
}
