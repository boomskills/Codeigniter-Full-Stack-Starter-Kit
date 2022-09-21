<?php

namespace Modules\Auth\Entities;

use App\Entities\BaseEntity;

class Role extends BaseEntity
{

    /**
     * Returns permissions belonging to this role
     */
    public function permissions()
    {
        $permissionModel = model(PermissionModel::class);
       return $permissionModel
            ->select('permissions.*')
            ->join('role_permissions', 'role_permissions.permission_id = permissions.id', 'inner')
            ->where('role_id', $this->id)
            ->findAll();

    }

    /**
     * Returns users belonging to this role
     */
    public function users()
    {
        $userModel = model(UserModel::class);
        return  $userModel
            ->select('users.*')
            ->join('role_users', 'role_users.user_id = users.id', 'inner')
            ->where('role_id', $this->id)
            ->findAll();
    }
}
