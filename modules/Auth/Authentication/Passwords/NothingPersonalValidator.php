<?php

namespace Modules\Auth\Authentication\Passwords;

use CodeIgniter\Entity\Entity;

/**
 * Class NothingPersonalValidator.
 *
 * Checks password does not contain any personal information
 */
class NothingPersonalValidator extends BaseValidator implements ValidatorInterface
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
     * Returns true if $password contains no part of the username
     * or the auth's email. Otherwise, it returns false.
     * If true is returned the password will be passed to next validator.
     * If false is returned the validation process will be immediately stopped.
     *
     * @param Entity $auth
     */
    public function check(string $password, Entity $auth = null): bool
    {
        $password = strtolower($password);

        if ($valid = true === $this->isNotPersonal($password, $auth)) {
            $valid = $this->isNotSimilar($password, $auth);
        }

        return $valid;
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

    /**
     * isNotPersonal().
     *
     * Looks for personal information in a password. The personal info used
     * comes from App\Entities\User properties name and email.
     *
     * It is possible to include other fields as information sources.
     * For instance, a project might require adding `firstname` and `lastname` properties
     * to an extended version of the User class.
     * The new fields can be included in personal information testing in by setting
     * the `$personalFields` property in App\Config\Auth, e.g.
     *
     *      public $personalFields = ['firstname', 'lastname'];
     *
     * isNotPersonal() returns true if no personal information can be found, or false
     * if such info is found.
     *
     * @param string $password
     * @param Entity $auth
     *
     * @return bool
     */
    protected function isNotPersonal($password, $auth)
    {

        $u = $auth;

        $userName = strtolower($auth->identity);
        $email = strtolower($auth->email);
        $valid = true;

        // The most obvious transgressions
        if (
            $password === $userName
            || $password === $email
            || $password === strrev($userName)
        ) {
            $valid = false;
        }

        // Parse out as many pieces as possible from username, password and email.
        // Use the pieces as needles and haystacks and look every which way for matches.
        if ($valid) {
            // Take username apart for use as search needles
            $needles = $this->strip_explode($userName);

            // extract local-part and domain parts from email as separate needles
            [$localPart, $domain] = explode('@', $email);
            // might be john.doe@example.com and we want all the needles we can get
            $emailParts = $this->strip_explode($localPart);
            if (!empty($domain)) {
                $emailParts[] = $domain;
            }
            $needles = array_merge($needles, $emailParts);

            // Get any other "personal" fields defined in config
            $personalFields = $this->config->personalFields;
            if (!empty($personalFields)) {
                foreach ($personalFields as $value) {
                    if (!empty($u->{$value})) {
                        $needles[] = strtolower($u->{$value});
                    }
                }
            }

            $trivial = [
                'a', 'an', 'and', 'as', 'at', 'but', 'for',
                'if', 'in', 'not', 'of', 'or', 'so', 'the', 'then',
            ];

            // Make password into haystacks
            $haystacks = $this->strip_explode($password);

            foreach ($haystacks as $haystack) {
                if (empty($haystack) || in_array($haystack, $trivial)) {
                    continue;  //ignore trivial words
                }

                foreach ($needles as $needle) {
                    if (empty($needle) || in_array($needle, $trivial)) {
                        continue;
                    }

                    // look both ways in case password is subset of needle
                    if (
                        false !== strpos($haystack, $needle)
                        || false !== strpos($needle, $haystack)
                    ) {
                        $valid = false;

                        break 2;
                    }
                }
            }
        }
        if ($valid) {
            return true;
        }

        $this->error = lang('Auth.errorPasswordPersonal');
        $this->suggestion = lang('Auth.suggestPasswordPersonal');

        return false;
    }

    /**
     * notSimilar() uses $password and $userName to calculate a similarity value.
     * Similarity values equal to, or greater than App\Config::maxSimilarity
     * are rejected for being too much alike and false is returned.
     * Otherwise, true is returned,.
     *
     * A $maxSimilarity value of 0 (zero) returns true without making a comparison.
     * In other words, 0 (zero) turns off similarity testing.
     *
     * @param string $password
     * @param Entity $auth
     *
     * @return bool
     */
    protected function isNotSimilar($password, $auth)
    {
        $maxSimilarity = (float) $this->config->maxSimilarity;
        // sanity checking - working range 1-100, 0 is off
        if ($maxSimilarity < 1) {
            $maxSimilarity = 0;
        } elseif ($maxSimilarity > 100) {
            $maxSimilarity = 100;
        }

        if (!empty($maxSimilarity)) {
            // note we user identity field on the authentication table, but can be changed to user username if your system support
            $userName = strtolower($auth->identity);

            similar_text($password, $userName, $similarity);
            if ($similarity >= $maxSimilarity) {
                $this->error = lang('Auth.errorPasswordTooSimilar');
                $this->suggestion = lang('Auth.suggestPasswordTooSimilar');

                return false;
            }
        }

        return true;
    }

    /**
     * strip_explode($str).
     *
     * Replaces all non-word characters and underscores in $str with a space.
     * Then it explodes that result using the space for a delimiter.
     *
     * @param string $str
     *
     * @return array
     */
    protected function strip_explode($str)
    {
        $stripped = preg_replace('/[\W_]+/', ' ', $str);
        $parts = explode(' ', trim($stripped));

        // If it's not already there put the untouched input at the top of the array
        if (!in_array($str, $parts)) {
            array_unshift($parts, $str);
        }

        return $parts;
    }
}
