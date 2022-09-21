<?php

namespace Modules\Auth\Authentication;

use CodeIgniter\Events\Events;
use Modules\Auth\Config\Auth as AuthConfig;
use Modules\Auth\Entities\Auth;
use Modules\Auth\Exceptions\AuthException;
use Modules\Auth\Exceptions\AuthNotFoundException;
use Modules\Auth\Models\AuthModel;
use Modules\Auth\Models\LoginModel;

class AuthenticationBase
{
    /**
     * @var null|Auth
     */
    protected $auth;

    /**
     * @var AuthModel
     */
    protected $authModel;

    /**
     * @var LoginModel
     */
    protected $loginModel;

    /**
     * @var string
     */
    protected $error;

    /**
     * @var AuthConfig
     */
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Returns the current error, if any.
     *
     * @return string
     */
    public function error()
    {
        return $this->error;
    }

    /**
     * Whether to continue instead of throwing exceptions,
     * as defined in config.
     *
     * @return bool
     */
    public function silent()
    {
        return (bool) $this->config->silent;
    }

    /**
     * Logs a auth into the system.
     * NOTE: does not perform validation. All validation should
     * be done prior to using the login method.
     *
     * @param Auth $auth
     *
     * @throws \Exception
     */
    public function login(Auth $auth = null, bool $remember = false): bool
    {
        if (empty($auth)) {
            $this->auth = null;

            return false;
        }

        $this->auth = $auth;

        // Always record a login attempt
        $ipAddress = service('request')->getIPAddress();

        $this->recordLoginAttempt($auth->identity, $ipAddress, true, $auth->user_id);

        // Regenerate the session ID to help protect against session fixation
        if (ENVIRONMENT !== 'testing') {
            session()->regenerate();
        }

        // Let the session know we're logged in
        session()->set('logged_in', $this->auth->user_id);

        // When logged in, ensure cache control headers are in place
        service('response')->noCache();

        if ($remember && $this->config->allowRemembering) {
            $this->rememberAuth($this->auth->user_id);
        }

        // We'll give a 20% chance to need to do a purge since we
        // don't need to purge THAT often, it's just a maintenance issue.
        // to keep the table from getting out of control.
        if (mt_rand(1, 100) < 20) {
            $this->loginModel->purgeOldRememberTokens();
        }

        // update online timestamp
        if ($this->auth->online_timestamp < time() - 60 * 5) {
            $this->updateOnlineTimestamp($this->auth->user_id);
        }

        // trigger login event
        Events::trigger('login', $auth);

        return true;
    }

    /**
     * Checks to see if the user is logged in.
     */
    public function isLoggedIn(): bool
    {
        // On the off chance
        if ($this->auth instanceof Auth) {
            return true;
        }

        if ($authID = session('logged_in')) {
            // Store our current auth object
            $this->auth = $this->authModel->find($authID);

            // update online timestamp
            $this->updateOnlineTimestamp($this->auth->user_id);

            return $this->auth instanceof Auth;
        }

        return false;
    }

    /**
     * Logs a user into the system by their ID.
     */
    public function loginByID(int $id, bool $remember = false)
    {
        $auth = $this->retrieveAuth(['user_id' => $id]);

        if (empty($auth)) {
            throw AuthNotFoundException::forAuthID($id);
        }

        return $this->login($auth, $remember);
    }

    /**
     * Logs a user out of the system.
     */
    public function logout()
    {
        helper('cookie');

        // Destroy the session data - but ensure a session is still
        // available for flash messages, etc.
        if (isset($_SESSION)) {
            foreach ($_SESSION as $key => $value) {
                $_SESSION[$key] = null;
                unset($_SESSION[$key]);
            }
        }

        // Regenerate the session ID for a touch of added safety.
        session()->regenerate(true);

        // Remove the cookie
        delete_cookie('remember');

        // Handle auth tasks
        if ($auth = $this->auth()) {
            // Take care of any remember me functionality
            $this->loginModel->purgeRememberTokens($auth->user_id);

            // Trigger logout event
            Events::trigger('logout', $auth);

            $this->auth = null;
        }
    }

    /**
     * Record a login attempt.
     *
     * @param null|mixed $userId
     *
     * @return bool|int|string
     */
    public function recordLoginAttempt(string $identity, string $ipAddress = null, bool $success, $userId = null)
    {
        return $this->loginModel->insert([
            'ip_address' => $ipAddress,
            'identity' => $identity,
            'user_id' => $userId,
            'date' => date('Y-m-d H:i:s'),
            'success' => (int) $success,
        ]);
    }

    /**
     * Update online timestamp for the specified user id.
     *
     * @param null|mixed $authID
     */
    public function updateOnlineTimestamp($authID = null)
    {
        db_connect()->table('authentications')->where('user_id', $authID)->set(['online_timestamp' => time()])->update();
    }

    /**
     * Generates a timing-attack safe remember me token
     * and stores the necessary info in the db and a cookie.
     *
     * @see https://paragonie.com/blog/2015/04/secure-authentication-php-with-long-term-persistence
     *
     * @throws \Exception
     */
    public function rememberAuth(int $authID)
    {
        $selector = bin2hex(random_bytes(12));
        $validator = bin2hex(random_bytes(20));
        $expires = date('Y-m-d H:i:s', time() + $this->config->rememberLength);

        $token = $selector . ':' . $validator;

        // Store it in the database
        $this->loginModel->rememberUser($authID, $selector, hash('sha256', $validator), $expires);

        // update online timestamp
        $this->updateOnlineTimestamp($authID);

        // Save it to the user's browser in a cookie.
        $appConfig = config('App');
        $response = service('response');

        // Create the cookie
        $response->setCookie(
            'remember',                                  // Cookie Name
            $token,                                     // Value
            $this->config->rememberLength,              // # Seconds until it expires
            $appConfig->cookieDomain,
            $appConfig->cookiePath,
            $appConfig->cookiePrefix,
            $appConfig->cookieSecure,                   // Only send over HTTPS?
            true                                        // Hide from Javascript?
        );
    }

    /**
     * Sets a new validator for this user/selector. This allows
     * a one-time use of remember-me tokens, but still allows
     * a user to be remembered on multiple browsers/devices.
     */
    public function refreshRemember(int $authID, string $selector)
    {
        $existing = $this->loginModel->getRememberToken($selector);

        // No matching record? Shouldn't happen, but remember the user now.
        if (empty($existing)) {
            return $this->rememberAuth($authID);
        }

        // update online timestamp
        $this->updateOnlineTimestamp($authID);

        // Update the validator in the database and the session
        $validator = bin2hex(random_bytes(20));

        $this->loginModel->updateRememberValidator($selector, $validator);

        // Save it to the user's browser in a cookie.
        helper('cookie');

        $appConfig = config('App');

        // Create the cookie
        set_cookie(
            'remember',                              // Cookie Name
            $selector . ':' . $validator,                 // Value
            (string) $this->config->rememberLength, // # Seconds until it expires
            $appConfig->cookieDomain,
            $appConfig->cookiePath,
            $appConfig->cookiePrefix,
            $appConfig->cookieSecure,               // Only send over HTTPS?
            true                                    // Hide from Javascript?
        );
    }

    /**
     * Returns the Auth ID for the current logged in user.
     *
     * @return null|int
     */
    public function id()
    {
        return $this->auth->user_id ?? null;
    }

    /**
     * Returns the Auth instance for the current logged in user through the authentication system.
     *
     * @return null|Auth
     */
    public function auth()
    {
        return $this->auth;
    }

    /**
     * Grabs the current auth from the database.
     *
     * @return null|array|object
     */
    public function retrieveAuth(array $wheres)
    {
        if (!$this->authModel instanceof AuthModel) {
            throw AuthException::forInvalidModel('Auth');
        }

        return $this->authModel->where($wheres)->first();
    }

    //--------------------------------------------------------------------
    // Model Setters
    //--------------------------------------------------------------------

    /**
     * Sets the model that should be used to work with
     * user accounts.
     *
     * @return $this
     */
    public function setAuthModel(AuthModel $model)
    {
        $this->authModel = $model;

        return $this;
    }

    /**
     * Sets the model that should be used to record
     * login attempts (but failed and successful).
     *
     * @return $this
     */
    public function setLoginModel(LoginModel $model)
    {
        $this->loginModel = $model;

        return $this;
    }
}
