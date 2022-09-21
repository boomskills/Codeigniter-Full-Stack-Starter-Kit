<?php

namespace App\Libraries;

/**
 * CodeIgniter Slug Library.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Academic Free License version 3.0
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * http://opensource.org/licenses/AFL-3.0
 *
 * @author      Eric Barnes
 * @copyright   Copyright (c) Eric Barnes (http://ericlbarnes.com)
 * @license     http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 *
 * @see        http://code.ericlbarnes.com
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Slug Library.
 *
 * Nothing but legless, boneless creatures who are responsible for creating
 * magic "friendly urls" in your CodeIgniter application. Slugs are nocturnal
 * feeders, hiding during daylight hours.
 */
class Slug
{
    /**
     * The name of the table.
     *
     * @var string
     */
    public $table = '';

    /**
     * The primary id field in the table.
     *
     * @var string
     */
    public $id = 'id';

    /**
     * The URI Field in the table.
     *
     * @var string
     */
    public $field = 'uri';

    /**
     * The title field in the table.
     *
     * @var string
     */
    public $title = 'title';

    /**
     * The replacement (Either underscore or dash).
     *
     * @var string
     */
    public $replacement = 'dash';

    // ------------------------------------------------------------------------

    /**
     * Setup all vars.
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->set_config($config);
        log_message('debug', 'Slug Class Initialized');
    }

    // ------------------------------------------------------------------------

    /**
     * Manually Set Config.
     *
     * Pass an array of config vars to override previous setup
     *
     * @param   array
     * @param mixed $config
     */
    public function set_config($config = [])
    {
        if (!empty($config)) {
            foreach ($config as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Create a uri string.
     *
     * This wraps into the _check_uri method to take a character
     * string and convert into ascii characters.
     *
     * @param   mixed (string or array)
     * @param   int
     * @param mixed $data
     * @param mixed $id
     *
     * @uses    Slug::_check_uri()
     * @uses    Slug::create_slug()
     *
     * @return string
     */
    public function create_uri($data = '', $id = '')
    {
        if (empty($data)) {
            return false;
        }

        if (is_array($data)) {
            if (!empty($data[$this->field])) {
                return $this->_check_uri($this->create_slug($data[$this->field]), $id);
            }
            if (!empty($data[$this->title])) {
                return $this->_check_uri($this->create_slug($data[$this->title]), $id);
            }
        } elseif (is_string($data)) {
            return $this->_check_uri($this->create_slug($data), $id);
        }

        return false;
    }

    // ------------------------------------------------------------------------

    /**
     * Create Slug.
     *
     * Returns a string with all spaces converted to underscores (by default), accented
     * characters converted to non-accented characters, and non word characters removed.
     *
     * @param string $string      the string you want to slug
     * @param string $replacement will replace keys in map
     *
     * @return string
     */
    public function create_slug($string)
    {
        helper(['url', 'text', 'string']);
        $string = strtolower(url_title(convert_accented_characters($string), $this->replacement));

        return reduce_multiples($string, $this->_get_replacement(), true);
    }

    // ------------------------------------------------------------------------

    /**
     * Check URI.
     *
     * Checks other items for the same uri and if something else has it
     * change the name to "name-1".
     *
     * @param string $uri
     * @param int    $id
     * @param int    $count
     *
     * @return string
     */
    private function _check_uri($uri, $id = false, $count = 0)
    {
        $db = db_connect();
        helper(['url', 'text', 'string']);

        $new_uri = ($count > 0) ? $uri.$this->_get_replacement().$count : $uri;

        // Setup the query
        $q = $db->table($this->table)->select($this->field)->where($this->field, $new_uri);

        if ($id) {
            $q = $db->table($this->table)->where($this->id.' !=', $id);
        }

        if ($q->countAllResults() > 0) {
            return $this->_check_uri($uri, $id, ++$count);
        }

        return $new_uri;
    }

    // ------------------------------------------------------------------------

    /**
     * Get the replacement type.
     *
     * Either a dash or underscore generated off the term.
     *
     * @return string
     */
    private function _get_replacement()
    {
        return ('dash' === $this->replacement) ? '-' : '_';
    }
}