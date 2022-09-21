<?php

namespace Modules\Auth\Authentication\Passwords;

use Modules\Auth\Entities\Auth;

/**
 * Class ValidationRules.
 *
 * Provides auth-related validation rules for CodeIgniter 4.
 *
 * To use, add this class to Config/Validation.php, in the
 * $rulesets array.
 */
class ValidationRules
{
    /**
     * A validation helper method to check if the passed in
     * password will pass all of the validators currently defined.
     *
     * Handy for use in validation, but you will get a slightly
     * better security if this is done manually, since you can
     * personalize based on a specific auth at that point.
     *
     * @param string $value  Field value
     * @param string $error1 Error that will be returned (for call without validation data array)
     * @param array  $data   Validation data array
     * @param string $error2 Error that will be returned (for call with validation data array)
     *
     * @return bool
     */
    public function strong_password(string $value, string &$error1 = null, array $data = [], string &$error2 = null)
    {
        $checker = service('passwords');

        if (function_exists('auth') && auth()) {
            $auth = auth();
        } else {
            $auth = empty($data) ? $this->buildAuthFromRequest() : $this->buildAuthFromData($data);
        }

        $result = $checker->check($value, $auth);

        if (false === $result) {
            if (empty($data)) {
                $error1 = $checker->error();
            } else {
                $error2 = $checker->error();
            }
        }

        return $result;
    }

    /**
     * Builds a new auth instance from the global request.
     *
     * @return Auth
     */
    protected function buildAuthFromRequest()
    {
        $fields = $this->prepareValidFields();

        $data = array_filter(service('request')->getPost($fields));

        return (new Auth())->fill($data);
    }

    /**
     * Builds a new auth instance from assigned data..
     *
     * @param array $data Assigned data
     *
     * @return Auth
     */
    protected function buildAuthFromData(array $data = [])
    {
        $fields = $this->prepareValidFields();

        $data = array_intersect_key($data, array_fill_keys($fields, null));

        return (new Auth())->fill($data);
    }

    /**
     * Prepare valid user fields.
     */
    protected function prepareValidFields(): array
    {
        $config = config('Auth');
        $fields = array_merge($config->validFields, $config->personalFields);
        $fields[] = 'password';

        return $fields;
    }
}
