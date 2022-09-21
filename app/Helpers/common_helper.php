<?php

use App\Libraries\Slug;
use App\Libraries\Slugify;
use App\Libraries\IdGenerator;
use App\Libraries\UniqueID;

if (!function_exists('splitName')) {
    //  name into first and last names
    function splitName($name)
    {
        $name = trim($name);
        $last_name = (false === strpos($name, ' ')) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim(preg_replace('#' . preg_quote($last_name, '/') . '#', '', $name));

        return [$first_name, $last_name];
    }
}


/**
 * Get model data
 */
if (!function_exists("find")) {

    function find($model, $where)
    {
        if ($model === null || $where === null) {
            return null;
        }

        $model = $model->where($where)->first();

        if ($model === null) {
            return null;
        }

        return $model;
    }
}


/**
 * Slug
 */
if (!function_exists('slug')) {

    function slug($str)
    {
        return (new Slug(['replacement' => "-"]))->create_slug($str);
    }
}


/**
 * Create unique slug
 */
if (!function_exists('create_slug')) {

    function create_slug($str, $table)
    {
        return (new Slugify())->slug_unique($str, $table);
    }
}


if (!function_exists('makeHash')) {
    function makeHash()
    {
        return md5(rand(1, 100000) . 'fhsf' . rand(1, 100000));
    }
}

if (!function_exists('countable')) {
    function countable($model, $where = [])
    {
        if (!$model || !$where) {
            throw new Exception('No countable model.');
        }

        return count($model->builder()->getWhere($where)->getResult());
    }
}


if (!function_exists('toArray')) {
    function toArray($data)
    {
        return json_decode(json_encode((array) $data), true);
    }
}

if (!function_exists('toSpaceCase')) {
    function toSpaceCase($string)
    {
        return preg_replace('/([a-z])([A-Z])/s', '$1 $2', $string);
    }
}

if (!function_exists('toSnakeCase')) {
    function toSnakeCase($string)
    {
        return preg_replace('/([a-z])([A-Z])/s', '$1_$2', $string);
    }
}

if (!function_exists('toCamelCase')) {
    function toCamelCase($string)
    {
        return lcfirst(toClassCase($string));
    }
}

if (!function_exists('toClassCase')) {
    function toClassCase($string)
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
    }
}

// determine if the passed argument can be treated like a string.
if (!function_exists('isString')) {
    function isString($text)
    {
        return is_string($text) || (is_object($text) && method_exists($text, '__toString'));
    }
}

if (!function_exists('renderImage')) {
    function renderImage($image)
    {
        if ($image) {
            if (false === strpos($image, 'http')) {
                $image = base_url($image);
            }
        } else {
            $image = base_url(NO_IMAGE_PATH);
        }

        return $image;
    }
}

if (!function_exists('escape')) {
    // Sanitize Output Functions
    function escape($string)
    {
        return htmlentities($string, ENT_QUOTES, 'UTF-8');
    }
}

// Unique UUID
if (!function_exists('uniqueid')) {
    function uniqueid()
    {
        return substr(number_format(time() * rand(), 0, '', ''), 0, 12);
    }
}

/**
 * Generates uniques numbers
 * @return mixed
 */
if (!function_exists('makeUniqueID')) {
    function makeUniqueID($table, $field, $prefix = '', $length = 6)
    {
        return UniqueID::generate([
            'table' => $table,
            'field' => $field,
            'length' => $length,
            'prefix' => $prefix ?: date('y'),
        ]);
    }
}


if (!function_exists('ipDetails')) {
    function ipDetails($ip)
    {
        $json = file_get_contents("http://ipinfo.io/{$ip}");

        return json_decode($json);
    }
}
