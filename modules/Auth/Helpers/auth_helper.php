<?php

use App\Entities\User;
use App\Models\UserModel;
use Modules\Auth\Entities\Auth;

if (!function_exists('logged_in')) {
    /**
     * Checks to see if the auth is logged in.
     *
     * @return bool
     */
    function logged_in()
    {
        return service('authentication')->check();
    }
}

if (!function_exists('auth')) {
    /**
     * Returns the Auth instance for the currently logged in auth.
     *
     * @return null|Auth
     */
    function auth()
    {
        $authenticate = service('authentication');
        $authenticate->check();

        return $authenticate->auth();
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
        $authenticate = service('authentication');
        $authenticate->check();

        return $authenticate->id();
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
        $authenticate = service('authentication');
        $authorize = service('authorization');

        if ($authenticate->check()) {
            return $authorize->inRole($roles, $authenticate->id());
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
        $authenticate = service('authentication');
        $authorize = service('authorization');

        if ($authenticate->check()) {
            return $authorize->hasPermission($permission, $authenticate->id()) ?? false;
        }

        return false;
    }
}

if (!function_exists("generatePassword")) {

    /**
     * Generate a random password
     * @return string
     */
    function generatePassword($length = 8)
    {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}
