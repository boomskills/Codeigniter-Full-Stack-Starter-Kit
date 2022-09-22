<?php

namespace Modules\Admin\Controllers;

use Modules\Auth\Authorization\PermissionModel as Permission;
use Modules\Auth\Authorization\RoleModel as Role;

class RoleController extends BaseAdminController
{
    protected $roleModel;
    protected $permModel;

    public function __construct()
    {
        parent::__construct();
        $this->roleModel = new Role();
        $this->permModel = new Permission();
    }

    /**
     * Display a listing resources.
     *
     * @return mixed
     */
    public function index()
    {
        $this->data['roles'] = $this->roleModel->findAll();

        $this->data['panel_title'] = 'Roles';

        return $this->_render($this->admin->views['role']['index'], $this->data);
    }

    /**
     * Display the specified resource .
     *
     * @param null|mixed $id
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        $role = $this->roleModel->find($id);

        if (!$role) {
            return $this->template->__admin_error(lang('Error.role_not_found'), $this->data);
        }

        $role_permissions = $this->roleModel->getPermissionsForRole($id);

        $this->data['role'] = $role;
        $this->data['role_permissions'] = $role_permissions;
        $this->data['panel_title'] = $role->name;

        return $this->_render($this->admin->views['role']['edit_role'], $this->data);
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $role = $this->roleModel->find($id);

        if (!$role) {
            return redirect()->back()->withInput()->with('error', lang('Error.role_not_found'));
        }

        // permissions
        if ($this->request->getVar('permissions')) {
            if (!$this->validate([
                'permissions.*.name' => 'required|string|is_unique[permissions.name]',
            ], [
                'permissions.*.name' => [
                    'require' => 'Permission name is required',
                    'is_unique' => 'Permission name must be unique',
                ],
            ])) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $permissions = $this->request->getVar('permissions');

            // save permissions to database and return the id
            foreach ($permissions as $perm) {
                $permission = $this->permModel->insert([
                    'slug' => $this->slug->create_slug($perm->name),
                    'name' => $perm->name,
                ], true);

                // assign permission to role
                $this->roleModel->addPermissionToRole($permission, $role->id);
            }
        }

        $name = $this->request->getVar('name');

        $response = $this->crud->updateOne($this->roleModel, [
            'slug' => $this->slug->create_slug($name),
            'name' => $name,
        ], $role->id);

        if ($response['success']) {
            return redirect()->back()->withInput()->with('success', lang('Success.updated'));
        }

        return redirect()->back()->withInput()->with('error', $response['message']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param null|mixed $id
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $role = $this->roleModel->find($id);

        if (!$role) {
            return redirect()->back()->withInput()->with('error', lang('Error.role_not_found'));
        }

        // does roles has user?
        $users = $this->roleModel->getUsersForRole($id);

        if (count($users) > 0) {
            return redirect()->back()->withInput()->with('error', lang('Error.role_has_users'));
        }

        $this->roleModel->delete($id);

        return redirect()->back()->withInput()->with('success', lang('Success.role_deleted'));
    }
}
