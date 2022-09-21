<?php

namespace Modules\Admin\Config;

$routes->group('admin', ['namespace' => 'Modules\Admin\Controllers', 'filter' => 'role:admin,superadmin'], function ($routes) {
    $routes->get('dashboard', 'DashboardController::index');
    $routes->get('site_settings', 'SiteSettingController::index');
    $routes->put('site_settings', 'SiteSettingController::updateSettings');

    $routes->resource('pages', ['controller' => 'PageController', 'placeholder' => '(:num)']);

    $routes->resource('roles', ['controller' => 'RoleController', 'placeholder' => '(:num)']);
    $routes->post('roles/(:num)/permissions', 'RolePermissionController::assignPermission/$1', ['as' => 'role.assign.permission']);
    $routes->delete('roles/(:num)/permissions', 'RolePermissionController::removePermission/$1', ['as' => 'role.delete.permission']);
    $routes->get('permissions', 'PermissionController::index');

    $routes->resource('users', ['controller' => 'UserController', 'only' => ['index', 'edit', 'update', 'delete']]);
    $routes->resource('posts', ['controller' => 'PostController', 'placeholder' => '(:num)']);
    $routes->match(['get', 'post'], 'posts/(:num)/status', 'PostController::updatePostStatus/$1', ['as' => 'posts.update.status']);
});
