<?php

namespace Modules\Auth\Traits;

use CodeIgniter\Router\Exceptions\RedirectException;
use Modules\Auth\Authentication\LocalAuthenticator;
use Modules\Auth\Authorization\FlatAuthorization;

trait AuthTrait
{
    /**
     * Instance of Authentication Class.
     *
     * @var null|LocalAuthenticator
     */
    public $authenticate;

    /**
     * Instance of Authorization class.
     *
     * @var null|FlatAuthorization
     */
    public $authorize;

    /**
     * The alias for the authentication lib to load.
     *
     * @var string
     */
    protected $authenticationLib = 'local';

    /**
     * Have the auth classes already been loaded?
     *
     * @var bool
     */
    private $classesLoaded = false;

    /**
     * Verifies that a user is logged in.
     *
     * @param string $uri
     *
     * @throws RedirectException
     *
     * @return bool
     */
    public function restrict(string $uri = null, bool $returnOnly = false)
    {
        $this->setupAuthClasses();

        if ($this->authenticate->check()) {
            return true;
        }

        if (method_exists($this, 'setMessage')) {
            session()->setFlashdata('error', lang('Auth.notLoggedIn'));
        }

        if ($returnOnly) {
            return false;
        }

        if (empty($uri)) {
            throw new RedirectException(route_to('login'));
        }

        throw new RedirectException($uri);
    }

    /**
     * Ensures that the current user is in at least one of the passed in
     * roles. The roles can be passed in as either ID's or group names.
     * You can pass either a single item or an array of items.
     *
     * If the user is not a member of one of the roles will return
     * the user to the page they just came from as shown in
     * $_SERVER['']
     *
     * Example:
     *  restrictToRoles([1, 2, 3]);
     *  restrictToRoles(14);
     *  restrictToRoles('administrator');
     *  restrictToRoles( ['administrator', 'moderators'] );
     *
     * @param mixed  $roles
     * @param string $uri   the URI to redirect to on fail
     *
     * @throws RedirectException
     *
     * @return bool
     */
    public function restrictToRoles($roles, $uri = null)
    {
        $this->setupAuthClasses();

        if ($this->authenticate->check()) {
            if ($this->authorize->inRole($roles, $this->authenticate->id())) {
                return true;
            }
        }

        if (method_exists($this, 'setMessage')) {
            session()->setFlashdata('error', lang('Auth.notEnoughPrivilege'));
        }

        if (empty($uri)) {
            throw new RedirectException(route_to('login').'?request_uri='.current_url());
        }

        throw new RedirectException($uri.'?request_uri='.current_url());
    }

    /**
     * Ensures that the current user has at least one of the passed in
     * permissions. The permissions can be passed in either as ID's or names.
     * You can pass either a single item or an array of items.
     *
     * If the user does not have one of the permissions it will return
     * the user to the URI set in $url or the site root, and attempt
     * to set a status message.
     *
     * @param        $permissions
     * @param string $uri         the URI to redirect to on fail
     *
     * @throws RedirectException
     *
     * @return bool
     */
    public function restrictWithPermissions($permissions, $uri = null)
    {
        $this->setupAuthClasses();

        if ($this->authenticate->check()) {
            if ($this->authorize->hasPermission($permissions, $this->authenticate->id())) {
                return true;
            }
        }

        if (method_exists($this, 'setMessage')) {
            session()->setFlashdata('error', lang('Auth.notEnoughPrivilege'));
        }

        if (empty($uri)) {
            throw new RedirectException(route_to('login').'?request_uri='.current_url());
        }

        throw new RedirectException($uri.'?request_uri='.current_url());
    }

    /**
     * Ensures that the Authentication and Authorization libraries are
     * loaded and ready to go, if they are not already.
     *
     * Uses the following config values:
     *      - auth.authenticate_lib
     *      - auth.authorize_lib
     */
    public function setupAuthClasses()
    {
        if ($this->classesLoaded) {
            return;
        }

        // Authentication
        $this->authenticate = service('authentication', $this->authenticationLib);

        // Try to log us in automatically.
        $this->authenticate->check();

        // Authorization
        $this->authorize = service('authorization');

        $this->classesLoaded = true;
    }
}