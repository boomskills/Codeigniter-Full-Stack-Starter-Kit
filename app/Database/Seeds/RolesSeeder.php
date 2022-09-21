<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Modules\Auth\Authorization\PermissionModel as Permission;
use Modules\Auth\Authorization\RoleModel as Role;

class RolesSeeder extends Seeder
{
    /**
     * @var array
     */
    public $roles = [
        ['name' => 'Super Admin', 'slug' => 'superadmin'],
        ['name' => 'Admin', 'slug' => 'admin'],
        ['name' => 'User', 'slug' => 'user'],
    ];

    /**
     * @var array
     */
    public $permissions = [
        ['name' => 'list users', 'slug' => 'list_users'],
        ['name' => 'view users', 'slug' => 'view_users'],
        ['name' => 'create users', 'slug' => 'create_users'],
        ['name' => 'delete users', 'slug' => 'delete_users'],
        ['name' => 'update users', 'slug' => 'update_users'],
        ['name' => 'manage user roles', 'slug' => 'manage_user_roles'],

        ['name' => 'list posts', 'slug' => 'list_posts'],
        ['name' => 'view posts', 'slug' => 'view_posts'],
        ['name' => 'create posts', 'slug' => 'create_posts'],
        ['name' => 'delete posts', 'slug' => 'delete_posts'],
        ['name' => 'update posts', 'slug' => 'update_posts'],
        ['name' => 'publish posts', 'slug' => 'publish_posts'],
        ['name' => 'review posts', 'slug' => 'review posts'],

        ['name' => 'manage permissions', 'slug' => 'manage_permissions'],
    ];

    /**
     * Run the database seeders.
     */
    public function run()
    {
        $this->createRoles()->createPermissions()->assignAllPermissionsToAdminRole();
    }

    /**
     * @return $this
     */
    public function createRoles()
    {
        foreach ($this->roles as $role) {
            $roleModel = new Role();
            if (!$roleModel->where('slug', $role['slug'])->first()) {
                $roleModel->insert($role);
            }
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function createPermissions()
    {
        foreach ($this->permissions as $perm) {
            // prevent reassigning
            $permModel = new Permission();
            if (!$permModel->where('slug', $perm['slug'])->first()) {
                $permModel->insert($perm);
            }
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function assignAllPermissionsToAdminRole()
    {
        $roleModel = new Role();
        $permModel = new Permission();

        $db = \Config\Database::connect();

        $role = $roleModel->find(2);

        $permissions = $permModel->findAll();

        foreach ($permissions as $perm) {
            $check = $db->table('role_permissions')->getWhere(['role_id' => $role->id, 'permission_id' => $perm->id])->getRow();

            if (!$check) {
                $db->table('role_permissions')->insert([
                    'role_id' => $role->id,
                    'permission_id' => $perm->id,
                ]);
            }
        }

        return $this;
    }
}
