<?php

namespace Modules\Auth\Authentication\Activators;

use App\Entities\User;
use Modules\Auth\Entities\Auth;

/**
 * Interface ActivatorInterface.
 */
interface ActivatorInterface
{
    /**
     * Send activation message to user.
     *
     * @param User $user
     * @param Auth $auth
     */
    public function send(User $user = null, Auth $auth = null): bool;

    /**
     * Returns the error string that should be displayed to the user.
     */
    public function error(): string;
}