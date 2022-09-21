<?php

namespace Modules\Auth\Authentication\Resetters;

use App\Entities\User;
use Modules\Auth\Config\Auth as AuthConfig;
use Modules\Auth\Entities\Auth;

abstract class BaseResetter
{
    /**
     * @var AuthConfig
     */
    protected $config;

    /**
     * @var string
     */
    protected $error = '';

    /**
     * Sets the initial config file.
     */
    public function __construct(AuthConfig $config = null)
    {
        $this->config = $config ?? config('Auth');
    }

    /**
     * Sends a reset message to user.
     *
     * @param User $user
     * @param Auth $auth
     */
    abstract public function send(User $user = null, Auth $auth = null): bool;

    /**
     * Allows for changing the config file on the Resetter.
     *
     * @return $this
     */
    public function setConfig(AuthConfig $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Gets a config settings for current Resetter.
     *
     * @return object
     */
    public function getResetterSettings()
    {
        return (object) $this->config->userResetters[static::class];
    }

    /**
     * Returns the current error.
     */
    public function error(): string
    {
        return $this->error;
    }
}