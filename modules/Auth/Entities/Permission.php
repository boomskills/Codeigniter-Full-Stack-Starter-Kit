<?php

namespace Modules\Auth\Entities;

use App\Entities\BaseEntity;

class Permission extends BaseEntity
{

    /**
     * Returns roles belonging to this permission
     */
    public function roles()
    {
        $roleModel = model(RoleModel::class);
        return $roleModel
            ->select('roles.*')
            ->join('role_permissions', 'role_permissions.role_id = roles.id', 'inner')
            ->where('permission_id', $this->id)
            ->findAll();
    }

    /**
     * Returns users belonging to this permission
     */
    public function users()
    {
        $userModel = model(UserModel::class);
        return  $userModel
            ->select('users.*')
            ->join('role_users', 'role_users.user_id = users.id', 'inner')
            ->where('permission_id', $this->id)
            ->findAll();
    }
}
