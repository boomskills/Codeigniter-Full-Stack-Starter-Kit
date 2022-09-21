<?php

use App\Entities\User;
use App\Models\UserModel;

if (!function_exists('logged_in')) {
    /**
     * Checks to see if the auth is logged in.
     *
     * @return bool
     */
    function logged_in()
    {
        return service('auth')->check();
    }
}


if (!function_exists('auth_id')) {
    /**
     * Returns the Authenticated User ID for the current logged in user from the authentication system.
     *
     * @return null|int
     */
    function auth_id()
    {
        $auth = service('auth');
        $auth->check();

        return $auth->id();
    }
}

if (!function_exists('user')) {
    /**
     * Returns a user by authenticated Id or provided id.
     *
     * @return null|User
     */
    function user($id = null)
    {
        return (new UserModel())->where("id", auth_id() ?? $id)->first();
    }
}

if (!function_exists('in_roles')) {
    /**
     * Ensures that the current user is in at least one of the passed in
     * roles. The roles can be passed in as either ID's or group names.
     * You can pass either a single item or an array of items.
     *
     * Example:
     *  in_roles([1, 2, 3]);
     *  in_roles(14);
     *  in_roles('admin');
     *  in_roles( ['admin', 'moderators'] );
     *
     * @param mixed $roles
     */
    function in_roles($roles): bool
    {
        $auth = service('auth');
        $authorize = service('authorization');

        if ($auth->check()) {
            return $authorize->inRole($roles, $auth->id());
        }

        return false;
    }
}

if (!function_exists('has_permission')) {
    /**
     * Ensures that the current user has the passed in permission.
     * The permission can be passed in either as an ID or name.
     *
     * @param int|string $permission
     */
    function has_permission($permission): bool
    {
        $auth = service('auth');
        $authorize = service('authorization');

        if ($auth->check()) {
            return $authorize->hasPermission($permission, $auth->id()) ?? false;
        }

        return false;
    }
}
