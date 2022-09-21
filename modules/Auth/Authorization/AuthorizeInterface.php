<?php

namespace Modules\Auth\Authorization;

interface AuthorizeInterface
{
    /**
     * Returns the latest error string.
     *
     * @return mixed
     */
    public function error();

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
     * @param mixed $Roles
     *
     * @return bool
     */
    public function inRole($Roles, int $userId);

    /**
     * Checks a user's Roles to see if they have the specified permission.
     *
     * @param int|string $permission
     *
     * @return mixed
     */
    public function hasPermission($permission, int $userId);

    /**
     * Makes a member a part of a role.
     *
     * @param int|string $role Either ID or name
     *
     * @return bool
     */
    public function addUserToRole(int $userid, $role);

    /**
     * Removes a single user from a role.
     *
     * @param int|string $role
     *
     * @return mixed
     */
    public function removeUserFromRole(int $userId, $role);

    /**
     * Adds a single permission to a single role.
     *
     * @param int|string $permission
     * @param int|string $role
     *
     * @return mixed
     */
    public function addPermissionToRole($permission, $role);

    /**
     * Removes a single permission from a role.
     *
     * @param int|string $permission
     * @param int|string $role
     *
     * @return mixed
     */
    public function removePermissionFromRole($permission, $role);

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
    public function role($role);

    /**
     * Grabs an array of all Roles.
     *
     * @return array of objects
     */
    public function Roles();

    /**
     * @return mixed
     */
    public function createRole(string $name, string $slug);

    /**
     * Deletes a single role.
     *
     * @return bool
     */
    public function deleteRole(int $roleId);

    /**
     * Updates a single role's information.
     *
     * @return mixed
     */
    public function updaterole(int $id, string $name, string $slug);

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
    public function permission($permission);

    /**
     * Returns an array of all permissions in the system.
     *
     * @return mixed
     */
    public function permissions();

    /**
     * Creates a single permission.
     *
     * @return mixed
     */
    public function createPermission(string $name, string $slug);

    /**
     * Deletes a single permission and removes that permission from all Roles.
     *
     * @return mixed
     */
    public function deletePermission(int $permissionId);

    /**
     * Updates the details for a single permission.
     *
     * @return bool
     */
    public function updatePermission(int $id, string $name, string $slug);
}