<?php

namespace Modules\Auth\Authentication;

use Modules\Auth\Entities\Auth;

interface AuthenticatorInterface
{
    /**
     * Attempts to validate the credentials and log a user in.
     *
     * @param bool $remember Should we remember the user (if enabled)
     */
    public function attempt(array $credentials, bool $remember = null): bool;

    /**
     * Checks to see if the auth is logged in or not.
     */
    public function check(): bool;

    /**
     * Checks the auth's credentials to see if they could authenticate.
     * Unlike `attempt()`, will not log the auth into the system.
     *
     * @return Auth|bool
     */
    public function validate(array $credentials, bool $returnAuth = false);

    /**
     * Returns the Auth instance for the current logged in auth.
     *
     * @return null|Auth
     */
    public function auth();
}