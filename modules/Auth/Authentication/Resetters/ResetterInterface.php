<?php

namespace Modules\Auth\Authentication\Resetters;

use App\Entities\User;
use Modules\Auth\Entities\Auth;

/**
 * Interface ResetterInterface.
 */
interface ResetterInterface
{
    /**
     * Send reset message to user.
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