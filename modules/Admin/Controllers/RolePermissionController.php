<?php

namespace Modules\Admin\Controllers;

use Modules\Auth\Authorization\RoleModel as Role;

class RolePermissionController extends BaseAdminController
{
    protected $roleModel;

    public function __construct()
    {
        parent::__construct();
        $this->roleModel = new Role();
    }


    /**
     * Assign permission to a specified role.
     *
     * @param null|mixed $roleId
     */
    public function assignPermission($roleId = null)
    {
        $role = $this->roleModel->find($roleId);

        if (!$role) {
            return $this->fail(lang('Error.role_not_found'));
        }

        if (!$this->validate([
            'permission_ids.*' => 'required|array|is_not_unique[permissions.id]',
        ], [
            'permission_ids.*' => [
                'require' => 'At least permission is required',
                'is_not_unique' => 'Invalid permission id! Make sure the permission exist.',
            ],
        ])) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $permissionIds = $this->request->getVar('permission_ids');

        foreach ($permissionIds as $permId) {
            // if role alread assigned
            if (!$this->rolePermModel->where('role_id', $role->id)->where('permission_id', $permId)->first()) {
                $this->rolePermModel->builder->insert([
                    'role_id' => $roleId,
                    'permission_id' => $permId,
                ]);
            }
        }

        return $this->respondCreated(lang('Success.role_permission_assigned'));
    }

    /**
     * Remove permission from a specified role.
     *
     * @param null|mixed $roleId
     */
    public function removePermission($roleId = null)
    {
        $role = $this->roleModel->find($roleId);

        if (!$role) {
            return $this->fail(lang('Error.role_not_found'));
        }

        if (!$this->validate([
            'permission_ids.*' => 'required',
        ])) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $permissionIds = $this->request->getVar('permission_ids');

        foreach ($permissionIds as $permId) {
            // check if exist
            if ($this->rolePermModel->where('role_id', $roleId)->where('permission_id', $permId)->first()) {
                $this->rolePermModel->where('role_id', $roleId)->where('permission_id', $permId)->delete();
            }
        }

        return $this->respond(lang('Success.role_permission_removed'));
    }
}
