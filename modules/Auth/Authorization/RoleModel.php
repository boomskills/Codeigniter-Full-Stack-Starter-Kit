<?php

namespace Modules\Auth\Authorization;

use CodeIgniter\Model;
use Modules\Auth\Entities\Role;

class RoleModel extends Model
{
    protected $table = 'roles';
    protected $returnType = Role::class;
    protected $allowedFields = ['slug', 'name'];
    protected $useTimestamps = false;

    protected $validationRules = [
        'slug' => 'required|max_length[255]|is_unique[roles.slug,slug,{slug}]',
        'name' => 'required|max_length[255]|is_unique[roles.name,name,{name}]',
    ];

    //--------------------------------------------------------------------
    // Users
    //--------------------------------------------------------------------

    /**
     * Adds a single user to a single role.
     *
     * @return bool
     */
    public function addUserToRole(int $userId, int $roleId)
    {
        cache()->delete("{$roleId}_users");
        cache()->delete("{$userId}_roles");
        cache()->delete("{$userId}_permissions");

        $data = [
            'user_id' => (int) $userId,
            'role_id' => (int) $roleId,
        ];

        return (bool) $this->db->table('role_users')->insert($data);
    }

    /**
     * Removes a single user from a single role.
     *
     * @param int|string $roleId
     *
     * @return bool
     */
    public function removeUserFromRole(int $userId, $roleId)
    {
        cache()->delete("{$roleId}_users");
        cache()->delete("{$userId}_roles");
        cache()->delete("{$userId}_permissions");

        return $this->db->table('role_users')
            ->where([
                'user_id' => $userId,
                'role_id' => (int) $roleId,
            ])->delete();
    }

    /**
     * Removes a single user from all roles.
     *
     * @return bool
     */
    public function removeUserFromAllRoles(int $userId)
    {
        cache()->delete("{$userId}_roles");
        cache()->delete("{$userId}_permissions");

        return $this->db->table('role_users')
            ->where('user_id', (int) $userId)
            ->delete();
    }

    /**
     * Returns an array of all roles that a user is a member of.
     *
     * @return array
     */
    public function getRolesForUser(int $userId)
    {
        if (null === $found = cache("{$userId}_roles")) {
            $found = $this->builder()
                ->select('role_users.*, roles.slug, roles.name')
                ->join('role_users', 'role_users.role_id = roles.id', 'left')
                ->where('user_id', $userId)
                ->get()->getResultArray();

            cache()->save("{$userId}_roles", $found, 300);
        }

        return $found;
    }

    /**
     * Returns an array of all users that are members of a Role.
     *
     * @return array
     */
    public function getUsersForRole(int $roleId)
    {
        if (null === $found = cache("{$roleId}_users")) {
            $found = $this->builder()
                ->select('role_users.*, users.*')
                ->join('role_users', 'role_users.role_id = roles.id', 'left')
                ->join('users', 'role_users.user_id = users.id', 'left')
                ->where('roles.id', $roleId)
                ->get()->getResultArray();

            cache()->save("{$roleId}_users", $found, 300);
        }

        return $found;
    }

    //--------------------------------------------------------------------
    // Permissions
    //--------------------------------------------------------------------

    /**
     * Gets all permissions for a role in a way that can be
     * easily used to check against:.
     *
     * [
     *  id => slug,
     *  id => slug
     * ]
     */
    public function getPermissionsForRole(int $roleId): array
    {
        $permissionModel = model(PermissionModel::class);
        $fromRole = $permissionModel
            ->select('permissions.*')
            ->join('role_permissions', 'role_permissions.permission_id = permissions.id', 'inner')
            ->where('role_id', $roleId)
            ->findAll();

        $found = [];
        foreach ($fromRole as $permission) {
            $found[$permission['id']] = $permission;
        }

        return $found;
    }

    /**
     * Add a single permission to a single role, by IDs.
     *
     * @return mixed
     */
    public function addPermissionToRole(int $permissionId, int $roleId)
    {
        $data = [
            'permission_id' => (int) $permissionId,
            'role_id' => (int) $roleId,
        ];

        return $this->db->table('role_permissions')->insert($data);
    }

    //--------------------------------------------------------------------

    /**
     * Removes a single permission from a single role.
     *
     * @return mixed
     */
    public function removePermissionFromRole(int $permissionId, int $roleId)
    {
        return $this->db->table('role_permissions')
            ->where([
                'permission_id' => $permissionId,
                'role_id' => $roleId,
            ])->delete();
    }

    //--------------------------------------------------------------------

    /**
     * Removes a single permission from all roles.
     *
     * @return mixed
     */
    public function removePermissionFromAllRoles(int $permissionId)
    {
        return $this->db->table('role_permissions')
            ->where('permission_id', $permissionId)
            ->delete();
    }
}
