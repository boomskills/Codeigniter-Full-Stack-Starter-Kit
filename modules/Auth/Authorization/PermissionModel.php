<?php

namespace Modules\Auth\Authorization;

use CodeIgniter\Model;
use CodeIgniter\Database\Query;
use CodeIgniter\Database\BaseResult;
use Modules\Auth\Entities\Permission;

class PermissionModel extends Model
{
    protected $table = 'permissions';
    protected $returnType = Permission::class;
    protected $allowedFields = [
        'slug',
        'name',
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'slug' => 'required|max_length[255]|is_unique[permissions.slug,slug,{slug}]',
        'name' => 'required|max_length[255]|is_unique[permissions.name,name,{name}]',
    ];

    /**
     * Checks to see if a user, or one of their role,
     * has a specific permission.
     */
    public function doesUserHavePermission(int $userId, int $permissionId): bool
    {
        // Check user permissions and take advantage of caching
        $userPerms = $this->getPermissionsForUser($userId);

        if (count($userPerms) && array_key_exists($permissionId, $userPerms)) {
            return true;
        }

        // Check group permissions
        $count = $this->db->table('role_permissions')
            ->join('role_users', 'role_users.role_id = role_permissions.role_id', 'inner')
            ->where('role_permissions.permission_id', $permissionId)
            ->where('role_users.user_id', $userId)
            ->countAllResults();

        return $count > 0;
    }

    /**
     * Adds a single permission to a single user.
     *
     * @return BaseResult|false|Query
     */
    public function addPermissionToUser(int $permissionId, int $userId)
    {
        cache()->delete("{$userId}_permissions");

        return $this->db->table('user_permissions')->insert([
            'user_id' => $userId,
            'permission_id' => $permissionId,
        ]);
    }

    /**
     * Removes a permission from a user.
     *
     * @return mixed
     */
    public function removePermissionFromUser(int $permissionId, int $userId)
    {
        $this->db->table('user_permissions')->where([
            'user_id' => $userId,
            'permission_id' => $permissionId,
        ])->delete();

        cache()->delete("{$userId}_permissions");
    }

    /**
     * Gets all permissions for a user in a way that can be
     * easily used to check against:.
     *
     * [
     *  id => slug,
     *  id => slug
     * ]
     */
    public function getPermissionsForUser(int $userId): array
    {
        if (null === $found = cache("{$userId}_permissions")) {
            $fromUser = $this->db->table('user_permissions')
                ->select('id, permissions.slug')
                ->join('permissions', 'permissions.id = permission_id', 'inner')
                ->where('user_id', $userId)
                ->get()
                ->getResultObject();
            $fromRole = $this->db->table('role_users')
                ->select('permissions.id, permissions.slug')
                ->join('role_permissions', 'role_permissions.role_id = role_users.role_id', 'inner')
                ->join('permissions', 'permissions.id = role_permissions.permission_id', 'inner')
                ->where('user_id', $userId)
                ->get()
                ->getResultObject();

            $combined = array_merge($fromUser, $fromRole);

            $found = [];
            foreach ($combined as $row) {
                $found[$row->id] = $row->slug;
            }

            cache()->save("{$userId}_permissions", $found, 300);
        }

        return $found;
    }
}
