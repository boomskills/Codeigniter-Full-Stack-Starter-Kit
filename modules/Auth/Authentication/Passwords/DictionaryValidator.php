<?php

namespace Modules\Auth\Authentication\Passwords;

use CodeIgniter\Entity\Entity;

/**
 * Class DictionaryValidator.
 *
 * Checks passwords against a list of 65k commonly used passwords
 * that was compiled by InfoSec.
 */
class DictionaryValidator extends BaseValidator implements ValidatorInterface
{
    /**
     * @var string
     */
    protected $error;

    /**
     * @var string
     */
    protected $suggestion;

    /**
     * Checks the password against the words in the file and returns false
     * if a match is found. Returns true if no match is found.
     * If true is returned the password will be passed to next validator.
     * If false is returned the validation process will be immediately stopped.
     *
     * @param Entity $auth
     */
    public function check(string $password, Entity $auth = null): bool
    {
        // Loop over our file
        $fp = fopen(__DIR__.'/_dictionary.txt', 'r');
        if ($fp) {
            while (($line = fgets($fp, 4096)) !== false) {
                if ($password == trim($line)) {
                    fclose($fp);

                    $this->error = lang('Auth.errorPasswordCommon');
                    $this->suggestion = lang('Auth.suggestPasswordCommon');

                    return false;
                }
            }
        }

        fclose($fp);

        return true;
    }

    /**
     * Returns the error string that should be displayed to the user.
     */
    public function error(): string
    {
        return $this->error ?? '';
    }

    /**
     * Returns a suggestion that may be displayed to the user
     * to help them choose a better password. The method is
     * required, but a suggestion is optional. May return
     * an empty string instead.
     */
    public function suggestion(): string
    {
        return $this->suggestion ?? '';
    }
}
