<?php

namespace Modules\Auth\Traits;

use Modules\Auth\Models\AuthModel;
use Modules\Auth\Authorization\RoleModel;
use Modules\Auth\Authorization\PermissionModel;


trait HasAuth
{

    /**
     * Per-user permissions cache.
     *
     * @var array
     */
    protected $permissions = [];

    /**
     * Per-user roles cache.
     *
     * @var array
     */
    protected $roles = [];

    /**
     * Determines whether the user has the appropriate permission,
     * either directly, or through one of it's groups.
     *
     * @return bool
     */
    public function can(string $permission)
    {
        return in_array($permission, $this->getPermissions());
    }

    /**
     * Returns the user's permissions, formatted for simple checking:.
     *
     * [
     *    id => slug,
     *    id=> slug,
     * ]
     *
     * @return array|mixed
     */
    public function getPermissions()
    {
        if (empty($this->id)) {
            throw new \RuntimeException('Users must be created before getting permissions.');
        }

        if (empty($this->permissions)) {
            $this->permissions = (new PermissionModel())->getPermissionsForUser($this->id);
        }

        return $this->permissions;
    }

    /**
     * Returns the user's roles, formatted for simple checking:.
     *
     * [
     *    id => slug,
     *    id => slug,
     * ]
     *
     * @return array|mixed
     */
    public function getRoles()
    {
        if (empty($this->id)) {
            throw new \RuntimeException('Users must be created before getting roles.');
        }

        if (empty($this->roles)) {
            $roles = (new RoleModel())->getRolesForUser($this->id);

            foreach ($roles as $role) {
                $this->roles[$role['role_id']] = $role['slug'];
            }
        }

        return $this->roles;
    }

    /**
     * Warns the developer it won't work, so they don't spend
     * hours tracking stuff down.
     *
     * @param array $permissions
     *
     * @return $this
     */
    public function setPermissions(array $permissions = null)
    {
        throw new \RuntimeException('User entity does not support saving permissions directly.');
    }

    /**
     * A model belongs to auth
     *
     * @return mixed
     */
    public function auth()
    {
        return (new AuthModel())->where('user_id', $this->id)->first();
    }
}
