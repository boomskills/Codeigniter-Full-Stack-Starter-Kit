<?php

namespace Modules\Auth\Entities;

use App\Libraries\Password;
use App\Entities\BaseEntity;
use App\Models\UserModel;

class Auth extends BaseEntity
{
    /**
     * Define properties that are automatically converted to Time instances.
     */
    protected $dates = ['reset_at', 'reset_expires'];


    /**
     * An auth always belong to a user
     */
    public function user()
    {
        return (new UserModel())->find($this->user_id);
    }

    /**
     * Array of field names and the type of value to cast them as
     * when they are accessed.
     */
    protected $casts = [
        'active' => 'boolean',
        'force_pass_reset' => 'boolean',
    ];

    /**
     * Automatically hashes the password when set.
     *
     * @see https://paragonie.com/blog/2015/04/secure-authentication-php-with-long-term-persistence
     */
    public function setPassword(string $password)
    {
        $this->attributes['password_hash'] = Password::hash($password);

        /*
            Set these vars to null in case a reset password was asked.
            Scenario:
                user (a *dumb* one with short memory) requests a
                reset-token and then does nothing => asks the
                administrator to reset his password.
            User would have a new password but still anyone with the
            reset-token would be able to change the password.
        */
        $this->attributes['reset_hash'] = null;
        $this->attributes['reset_at'] = null;
        $this->attributes['reset_expires'] = null;
    }

    /**
     * Force a user to reset their password on next page refresh
     * or login. Checked in the LocalAuthenticator's check() method.
     *
     * @throws \Exception
     *
     * @return $this
     */
    public function forcePasswordReset()
    {
        $this->generateResetHash();
        $this->attributes['force_pass_reset'] = 1;

        return $this;
    }

    /**
     * Generates a secure hash to use for password reset purposes,
     * saves it to the instance.
     *
     * @throws \Exception
     *
     * @return $this
     */
    public function generateResetHash()
    {
        $this->attributes['reset_hash'] = bin2hex(random_bytes(16));
        $this->attributes['reset_expires'] = date('Y-m-d H:i:s', time() + config('Auth')->resetTime);

        return $this;
    }

    /**
     * Generates a secure random hash to use for account activation.
     *
     * @throws \Exception
     *
     * @return $this
     */
    public function generateActivateHash()
    {
        $this->attributes['activate_hash'] = bin2hex(random_bytes(16));

        return $this;
    }

    /**
     * Activate user.
     *
     * @return $this
     */
    public function activate()
    {
        $this->attributes['active'] = 1;
        $this->attributes['activate_hash'] = null;
        $this->attributes['activated_at'] = date('Y-m-d H:i:s');

        return $this;
    }

    /**
     * Deactivate user.
     *
     * @return $this
     */
    public function deactivate()
    {
        $this->attributes['active'] = 0;
        $this->attributes['activated_at'] = null;

        return $this;
    }

    /**
     * Checks to see if a user is active.
     */
    public function isActivated(): bool
    {
        return isset($this->attributes['active']) && true == $this->attributes['active'];
    }

    /**
     * Bans a user.
     *
     * @return $this
     */
    public function ban(string $reason)
    {
        $this->attributes['status'] = 'banned';
        $this->attributes['status_message'] = $reason;

        return $this;
    }

    /**
     * Removes a ban from a user.
     *
     * @return $this
     */
    public function unBan()
    {
        $this->attributes['status'] = $this->status_message = '';

        return $this;
    }

    /**
     * Checks to see if a user has been banned.
     */
    public function isBanned(): bool
    {
        return isset($this->attributes['status']) && 'banned' === $this->attributes['status'];
    }
}
