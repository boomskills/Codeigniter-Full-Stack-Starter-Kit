<?php

namespace Modules\Auth\Authentication\Passwords;

use CodeIgniter\Entity\Entity;
use Modules\Auth\Exceptions\AuthException;

/**
 * Class CompositionValidator.
 *
 * Checks the general makeup of the password.
 *
 * While older composition checks might have included different character
 * groups that you had to include, current NIST standards prefer to simply
 * set a minimum length and a long maximum (128+ chars).
 *
 * @see https://pages.nist.gov/800-63-3/sp800-63b.html#sec5
 */
class CompositionValidator extends BaseValidator implements ValidatorInterface
{
    /**
     * @var string
     */
    protected $error = '';

    /**
     * @var string
     */
    protected $suggestion = '';

    /**
     * Returns true when the password passes this test.
     * The password will be passed to any remaining validators.
     * False will immediately stop validation process.
     *
     * @param Entity $auth
     */
    public function check(string $password, Entity $auth = null): bool
    {
        if (empty($this->config->minimumPasswordLength)) {
            throw AuthException::forUnsetPasswordLength();
        }

        $passed = strlen($password) >= $this->config->minimumPasswordLength;

        if (!$passed) {
            $this->error = lang('Auth.errorPasswordLength', [$this->config->minimumPasswordLength]);
            $this->suggestion = lang('Auth.suggestPasswordLength');

            return false;
        }

        return true;
    }

    /**
     * Returns the error string that should be displayed to the user.
     */
    public function error(): string
    {
        return $this->error;
    }

    /**
     * Returns a suggestion that may be displayed to the user
     * to help them choose a better password. The method is
     * required, but a suggestion is optional. May return
     * an empty string instead.
     */
    public function suggestion(): string
    {
        return $this->suggestion;
    }
}
