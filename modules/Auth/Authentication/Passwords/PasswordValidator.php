<?php

namespace Modules\Auth\Authentication\Passwords;

use Modules\Auth\Config\Auth as AuthConfig;
use Modules\Auth\Entities\Auth;
use Modules\Auth\Exceptions\AuthException;

class PasswordValidator
{
    /**
     * @var AuthConfig
     */
    protected $config;

    protected $error;

    protected $suggestion;

    public function __construct(AuthConfig $config)
    {
        $this->config = $config;
    }

    /**
     * Checks a password against all of the Validators specified
     * in `$passwordValidators` setting in Config\Auth.php.
     *
     * @param Auth $auth
     */
    public function check(string $password, Auth $auth = null): bool
    {
        if (is_null($auth)) {
            throw AuthException::forNoEntityProvided();
        }

        $password = trim($password);

        if (empty($password)) {
            $this->error = lang('Auth.errorPasswordEmpty');

            return false;
        }

        $valid = false;

        foreach ($this->config->passwordValidators as $className) {
            $class = new $className();
            $class->setConfig($this->config);

            if (false === $class->check($password, $auth)) {
                $this->error = $class->error();
                $this->suggestion = $class->suggestion();

                $valid = false;

                break;
            }

            $valid = true;
        }

        return $valid;
    }

    /**
     * Returns the current error, as defined by validator
     * it failed to pass.
     *
     * @return mixed
     */
    public function error()
    {
        return $this->error;
    }

    /**
     * Returns a string with any suggested fix
     * based on the validator it failed to pass.
     *
     * @return mixed
     */
    public function suggestion()
    {
        return $this->suggestion;
    }
}