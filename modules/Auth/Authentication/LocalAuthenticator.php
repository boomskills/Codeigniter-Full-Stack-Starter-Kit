<?php

namespace Modules\Auth\Authentication;

use App\Libraries\Password;
use Modules\Auth\Entities\Auth;
use Modules\Auth\Exceptions\AuthException;
use CodeIgniter\Router\Exceptions\RedirectException;

class LocalAuthenticator extends AuthenticationBase implements AuthenticatorInterface
{
    /**
     * Attempts to validate the credentials and log a auth in.
     *
     * @param bool $remember Should we remember the auth (if enabled)
     */
    public function attempt(array $credentials, bool $remember = null): bool
    {
        $this->auth = $this->validate($credentials, true);
        $ipAddress = service('request')->getIPAddress();

        if (empty($this->auth)) {
            // Always record a login attempt, whether success or not.
            $this->recordLoginAttempt($credentials['username'], $ipAddress, false);
            $this->auth = null;
            return false;
        }

        if ($this->auth->isBanned()) {
            // Always record a login attempt, whether success or not.
            $this->recordLoginAttempt($credentials['username'], $ipAddress, false, $this->auth->user_id ?? null);
            $this->error = lang('Auth.authIsBanned');
            $this->auth = null;
            return false;
        }

        if (!$this->auth->isActivated()) {
            // Always record a login attempt, whether success or not.
            $this->recordLoginAttempt($credentials['username'], $ipAddress, false, $this->auth->user_id ?? null);

            $param = http_build_query([
                'username' => urlencode($credentials['username']),
            ]);

            $this->error = lang('Auth.notActivated') . ' ' . anchor(route_to('resend-activate-account') . '?' . $param, lang('Auth.activationResend'));
            $this->auth = null;
            return false;
        }

        return $this->login($this->auth, $remember);
    }

    /**
     * Checks to see if the auth is logged in or not.
     */
    public function check(): bool
    {
        if ($this->isLoggedIn()) {
            // Do we need to force the user to reset their password?
            if ($this->auth && $this->auth->force_pass_reset) {
                throw new RedirectException(route_to('reset-password') . '?token=' . $this->auth->reset_hash);
            }

            return true;
        }

        // Check the remember me functionality.
        helper('cookie');
        $remember = get_cookie('remember');

        if (empty($remember)) {
            return false;
        }

        [$selector, $validator] = explode(':', $remember);
        $validator = hash('sha256', $validator);

        $token = $this->loginModel->getRememberToken($selector);

        if (empty($token)) {
            return false;
        }

        if (!hash_equals($token->hashedValidator, $validator)) {
            return false;
        }

        // Yay! We were remembered!
        $auth = $this->authModel->find($token->user_id);

        if (empty($auth)) {
            return false;
        }

        $this->login($auth);

        // We only want our remember me tokens to be valid
        // for a single use.
        $this->refreshRemember($auth->user_id, $selector);

        return true;
    }

    /**
     * Checks the user's authentication credentials to see if they could authenticate.
     * Unlike `attempt()`, will not log the user into the system.
     *
     * @return Auth|bool
     */
    public function validate(array $credentials, bool $returnAuth = false)
    {
        // Can't validate without a password.
        if (empty($credentials['password']) || count($credentials) < 2) {
            return false;
        }

        // Only allowed 1 additional credential other than password
        $password = $credentials['password'];
        unset($credentials['password']);

        if (count($credentials) > 1) {
            throw AuthException::forTooManyCredentials();
        }

        // Ensure that the fields are allowed validation fields
        if (!in_array(key($credentials), $this->config->validFields)) {
            throw AuthException::forInvalidFields(key($credentials));
        }

        // Can we find an auth with these credentials?
        $auth = $this->authModel->where($credentials)->first();

        if (!$auth) {
            $this->error = lang('Auth.badAttempt');

            return false;
        }

        // Now, try matching the passwords.
        if (!Password::verify($password, $auth->password_hash)) {
            $this->error = lang('Auth.invalidPassword');

            return false;
        }

        // Check to see if the password needs to be rehashed.
        // This would be due to the hash algorithm or hash
        // cost changing since the last time that a auth
        // logged in.
        if (Password::needsRehash($auth->password_hash, $this->config->hashAlgorithm)) {
            $auth->password = $password;
            $this->authModel->save($auth);
        }

        return $returnAuth ? $auth : true;
    }
}
