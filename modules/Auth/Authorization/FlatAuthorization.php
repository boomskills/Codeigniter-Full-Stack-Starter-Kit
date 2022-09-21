<?php

namespace Modules\Auth\Authorization;

use CodeIgniter\Events\Events;
use CodeIgniter\Model;
use App\Models\UserModel;

class FlatAuthorization implements AuthorizeInterface
{
    /**
     * @var null|array|string
     */
    protected $error;

    /**
     * The Role model to use. Usually the class noted
     * below (or an extension thereof) but can be any
     * compatible CodeIgniter Model.
     *
     * @var RoleModel
     */
    protected $roleModel;

    /**
     * The Role model to use. Usually the class noted
     * below (or an extension thereof) but can be any
     * compatible CodeIgniter Model.
     *
     * @var PermissionModel
     */
    protected $permissionModel;

    /**
     * The Role model to use. Usually the class noted
     * below (or an extension thereof) but can be any
     * compatible CodeIgniter Model.
     *
     * @var UserModel
     */
    protected $userModel;

    /**
     * Stores the models.
     *
     * @param RoleModel       $roleModel
     * @param PermissionModel $permissionModel
     *
     * @return null|array|string
     */
    public function __construct(Model $roleModel, Model $permissionModel)
    {
        $this->roleModel = $roleModel;
        $this->permissionModel = $permissionModel;
    }

    /**
     * Returns any error(s) from the last call.
     *
     * @return null|array|string
     */
    public function error()
    {
        return $this->error;
    }

    /**
     * Allows the consuming application to pass in a reference to the
     * model that should be used.
     *
     * @param UserModel $model
     *
     * @return mixed
     */
    public function setUserModel(Model $model)
    {
        $this->userModel = $model;

        return $this;
    }

    //--------------------------------------------------------------------
    // Actions
    //--------------------------------------------------------------------

    /**
     * Checks to see if a user is in a role.
     *
     * Roles can be either a string, with the name of the role, an INT
     * with the ID of the role, or an array of strings/ids that the
     * user must belong to ONE of. (It's an OR check not an AND check)
     *
     * @param mixed $roles
     * @param mixed $roles
     *
     * @return bool
     */
    public function inRole($roles, int $userId)
    {
        if (0 === $userId) {
            return false;
        }

        if (!is_array($roles)) {
            $roles = [$roles];
        }

        $userRoles = $this->roleModel->getRolesForUser((int) $userId);

        if (empty($userRoles)) {
            return false;
        }

        foreach ($roles as $role) {
            if (is_numeric($role)) {
                $ids = array_column($userRoles, 'role_id');
                if (in_array($role, $ids)) {
                    return true;
                }
            } elseif (is_string($role)) {
                $slugs = array_column($userRoles, 'slug');

                if (in_array($role, $slugs)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Checks a user's roles to see if they have the specified permission.
     *
     * @param int|string $permission Permission ID or name
     *
     * @return mixed
     */
    public function hasPermission($permission, int $userId)
    {
        // @phpstan-ignore-next-line
        if (empty($permission) || (!is_string($permission) && !is_numeric($permission))) {
            return null;
        }

        if (empty($userId) || !is_numeric($userId)) {
            return null;
        }

        // Get the Permission ID
        $permissionId = $this->getPermissionID($permission);

        if (!is_numeric($permissionId)) {
            return false;
        }

        // First check the permission model. If that exists, then we're golden.
        if ($this->permissionModel->doesUserHavePermission($userId, (int) $permissionId)) {
            return true;
        }

        // Still here? Then we have one last check to make - any user private permissions.
        return $this->doesUserHavePermission($userId, (int) $permissionId);
    }

    /**
     * Makes a member a part of a role.
     *
     * @param mixed $role Either ID or name, fails on anything else
     *
     * @return null|bool
     */
    public function addUserToRole(int $userId, $role)
    {
        if (empty($userId) || !is_numeric($userId)) {
            return null;
        }

        if (empty($role) || (!is_numeric($role) && !is_string($role))) {
            return null;
        }

        $roleId = $this->getRoleID($role);

        if (!Events::trigger('beforeAddUserToRole', $userId, $roleId)) {
            return false;
        }

        // Role ID
        if (!is_numeric($roleId)) {
            return null;
        }

        if (!$this->roleModel->addUserToRole($userId, (int) $roleId)) {
            $this->error = $this->roleModel->errors();

            return false;
        }

        Events::trigger('didAddUserToRole', $userId, $roleId);

        return true;
    }

    /**
     * Removes a single user from a role.
     *
     * @param mixed $role
     *
     * @return mixed
     */
    public function removeUserFromRole(int $userId, $role)
    {
        if (empty($userId) || !is_numeric($userId)) {
            return null;
        }

        if (empty($role) || (!is_numeric($role) && !is_string($role))) {
            return null;
        }

        $roleId = $this->getRoleID($role);

        if (!Events::trigger('beforeRemoveUserFromRole', $userId, $roleId)) {
            return false;
        }

        // Role ID
        if (!is_numeric($roleId)) {
            return false;
        }

        if (!$this->roleModel->removeUserFromRole($userId, $roleId)) {
            $this->error = $this->roleModel->errors();

            return false;
        }

        Events::trigger('didRemoveUserFromRole', $userId, $roleId);

        return true;
    }

    /**
     * Adds a single permission to a single role.
     *
     * @param int|string $permission
     * @param int|string $role
     *
     * @return mixed
     */
    public function addPermissionToRole($permission, $role)
    {
        $permissionId = $this->getPermissionID($permission);
        $roleId = $this->getRoleID($role);

        // Permission ID
        if (!is_numeric($permissionId)) {
            return false;
        }

        // Role ID
        if (!is_numeric($roleId)) {
            return false;
        }

        // Remove it!
        if (!$this->roleModel->addPermissionToRole($permissionId, $roleId)) {
            $this->error = $this->roleModel->errors();

            return false;
        }

        return true;
    }

    /**
     * Removes a single permission from a role.
     *
     * @param int|string $permission
     * @param int|string $role
     *
     * @return mixed
     */
    public function removePermissionFromRole($permission, $role)
    {
        $permissionId = $this->getPermissionID($permission);
        $roleId = $this->getRoleID($role);

        // Permission ID
        if (!is_numeric($permissionId)) {
            return false;
        }

        // Role ID
        if (!is_numeric($roleId)) {
            return false;
        }

        // Remove it!
        if (!$this->roleModel->removePermissionFromRole($permissionId, $roleId)) {
            $this->error = $this->roleModel->errors();

            return false;
        }

        return true;
    }

    /**
     * Assigns a single permission to a user, irregardless of permissions
     * assigned by roles. This is saved to the user's meta information.
     *
     * @param int|string $permission
     *
     * @return null|bool
     */
    public function addPermissionToUser($permission, int $userId)
    {
        $permissionId = $this->getPermissionID($permission);

        if (!is_numeric($permissionId)) {
            return null;
        }

        if (!Events::trigger('beforeAddPermissionToUser', $userId, $permissionId)) {
            return false;
        }

        $user = $this->userModel->find($userId);

        if (!$user) {
            $this->error = lang('Auth.userNotFound', [$userId]);

            return false;
        }

        /** @var User $user */
        $permissions = $user->getPermissions();

        if (!in_array($permissionId, $permissions)) {
            $this->permissionModel->addPermissionToUser($permissionId, $user->id);
        }

        Events::trigger('didAddPermissionToUser', $userId, $permissionId);

        return true;
    }

    /**
     * Removes a single permission from a user. Only applies to permissions
     * that have been assigned with addPermissionToUser, not to permissions
     * inherited based on roles they belong to.
     *
     * @param int|string $permission
     *
     * @return null|bool|mixed
     */
    public function removePermissionFromUser($permission, int $userId)
    {
        $permissionId = $this->getPermissionID($permission);

        if (!is_numeric($permissionId)) {
            return false;
        }

        if (empty($userId) || !is_numeric($userId)) {
            return null;
        }

        $userId = (int) $userId;

        if (!Events::trigger('beforeRemovePermissionFromUser', $userId, $permissionId)) {
            return false;
        }

        return $this->permissionModel->removePermissionFromUser($permissionId, $userId);
    }

    /**
     * Checks to see if a user has private permission assigned to it.
     *
     * @param int|string $userId
     * @param int|string $permission
     *
     * @return null|bool
     */
    public function doesUserHavePermission($userId, $permission)
    {
        $permissionId = $this->getPermissionID($permission);

        if (!is_numeric($permissionId)) {
            return false;
        }

        if (empty($userId) || !is_numeric($userId)) {
            return null;
        }

        return $this->permissionModel->doesUserHavePermission($userId, $permissionId);
    }

    //--------------------------------------------------------------------
    // Roles
    //--------------------------------------------------------------------

    /**
     * Grabs the details about a single role.
     *
     * @param int|string $role
     *
     * @return null|object
     */
    public function role($role)
    {
        if (is_numeric($role)) {
            return $this->roleModel->find((int) $role);
        }

        return $this->roleModel->where('slug', $role)->first();
    }

    /**
     * Grabs an array of all roles.
     *
     * @return array of objects
     */
    public function roles()
    {
        return $this->roleModel->orderBy('name', 'asc')->findAll();
    }

    /**
     * @return mixed
     */
    public function createRole(string $name, string $slug)
    {
        $data = [
            'name' => $name,
            'slug' => $slug,
        ];

        $validation = service('validation', null, false);
        $validation->setRules([
            'slug' => 'required|max_length[255]|is_unique[roles.slug]',
            'name' => 'required|max_length[255]|is_unique[roles.name]',
        ]);

        if (!$validation->run($data)) {
            $this->error = $validation->getErrors();

            return false;
        }

        $id = $this->roleModel->skipValidation()->insert($data);

        if (is_numeric($id)) {
            return (int) $id;
        }

        $this->error = $this->roleModel->errors();

        return false;
    }

    /**
     * Deletes a single role.
     *
     * @return bool
     */
    public function deleteRole(int $roleId)
    {
        if (!$this->roleModel->delete($roleId)) {
            $this->error = $this->roleModel->errors();

            return false;
        }

        return true;
    }

    /**
     * Updates a single role's information.
     *
     * @return mixed
     */
    public function updateRole(int $id, string $name, string $slug)
    {
        $data = [
            'name' => $name,
            'slug' => $slug,
        ];

        if (!$this->roleModel->update($id, $data)) {
            $this->error = $this->roleModel->errors();

            return false;
        }

        return true;
    }

    //--------------------------------------------------------------------
    // Permissions
    //--------------------------------------------------------------------

    /**
     * Returns the details about a single permission.
     *
     * @param int|string $permission
     *
     * @return null|object
     */
    public function permission($permission)
    {
        if (is_numeric($permission)) {
            return $this->permissionModel->find((int) $permission);
        }

        return $this->permissionModel->like('slug', $permission, 'none', null, true)->first();
    }

    /**
     * Returns an array of all permissions in the system.
     *
     * @return mixed
     */
    public function permissions()
    {
        return $this->permissionModel->findAll();
    }

    /**
     * Creates a single permission.
     *
     * @return mixed
     */
    public function createPermission(string $name, string $slug)
    {
        $data = [
            'name' => $name,
            'slug' => $slug,
        ];

        $validation = service('validation', null, false);
        $validation->setRules([
            'slug' => 'required|max_length[255]|is_unique[permissions.slug]',
            'name' => 'required|max_length[255]|is_unique[permissions.name]',
        ]);

        if (!$validation->run($data)) {
            $this->error = $validation->getErrors();

            return false;
        }

        $id = $this->permissionModel->skipValidation()->insert($data);

        if (is_numeric($id)) {
            return (int) $id;
        }

        $this->error = $this->permissionModel->errors();

        return false;
    }

    /**
     * Deletes a single permission and removes that permission from all roles.
     *
     * @return mixed
     */
    public function deletePermission(int $permissionIdId)
    {
        if (!$this->permissionModel->delete($permissionIdId)) {
            $this->error = $this->permissionModel->errors();

            return false;
        }

        // Remove the permission from all roles
        $this->roleModel->removePermissionFromAllRoles($permissionIdId);

        return true;
    }

    /**
     * Updates the details for a single permission.
     *
     * @return bool
     */
    public function updatePermission(int $id, string $name, string $slug)
    {
        $data = [
            'name' => $name,
            'slug' => $slug,
        ];

        if (!$this->permissionModel->update((int) $id, $data)) {
            $this->error = $this->permissionModel->errors();

            return false;
        }

        return true;
    }

    /**
     * Returns an array of all permissions in the system for a role
     * The role can be either the ID or the name of the role.
     *
     * @param int|string $role
     *
     * @return mixed
     */
    public function rolePermissions($role)
    {
        if (is_numeric($role)) {
            return $this->roleModel->getPermissionsForRole($role);
        }

        $role = $this->roleModel->where('slug', $role)->first();

        return $this->roleModel->getPermissionsForRole($role->id);
    }

    /**
     * Returns an array of all users in a role
     * The role can be either the ID or the name of the role.
     *
     * @param int|string $role
     *
     * @return mixed
     */
    public function usersInRole($role)
    {
        if (is_numeric($role)) {
            return $this->roleModel->getUsersForRole($role);
        }

        $role = $this->roleModel->where('slug', $role)->first();

        return $this->roleModel->getUsersForRole($role->id);
    }

    /**
     * Given a role, will return the role ID. The role can be either
     * the ID or the name of the role.
     *
     * @param int|string $role
     *
     * @return false|int
     */
    protected function getRoleID($role)
    {
        if (is_numeric($role)) {
            return (int) $role;
        }

        $role = $this->roleModel->where('slug', $role)->first();

        if (!$role) {
            $this->error = lang('Auth.roleNotFound', [$role]);

            return false;
        }

        return (int) $role->id;
    }

    /**
     * Verifies that a permission (either ID or the name) exists and returns
     * the permission ID.
     *
     * @param int|string $permission
     *
     * @return false|int
     */
    protected function getPermissionID($permission)
    {
        // If it's a number, we're done here.
        if (is_numeric($permission)) {
            return (int) $permission;
        }

        // Otherwise, pull it from the database.
        $p = $this->permissionModel->asObject()->where('slug', $permission)->first();

        if (!$p) {
            $this->error = lang('Auth.permissionNotFound', [$permission]);

            return false;
        }

        return (int) $p->id;
    }
}
