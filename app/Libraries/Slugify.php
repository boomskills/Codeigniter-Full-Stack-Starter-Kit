<?php

namespace App\Libraries;

/**
 * Class Slugify.
 *
 * creates a unique slugs
 */
class Slugify
{
    protected $latin;
    protected $plain;
    protected $primary_key = 'id';

    public function __construct()
    {
        $this->latin = ['á', 'é', 'í', 'ó', 'ú', 'ñ', 'ç', 'ü', 'à', 'è', 'ì', 'ò', 'ù', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ', 'Ç', 'Ü', 'À', 'È', 'Ì', 'Ò', 'Ù'];
        $this->plain = ['a', 'e', 'i', 'o', 'u', 'n', 'c', 'u', 'a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'N', 'C', 'U', 'A', 'E', 'I', 'O', 'U'];
    }

    public function slug($text)
    {
        helper('url');

        $slug = str_replace($this->latin, $this->plain, $text);
        $slug = url_title($slug);

        return strtolower($slug);
    }

    public function slug_unique($text, $table, $column = 'slug', $id = null)
    {
        helper('url');
        $slug = $this->slug($text);
        if ($this->_check_table($slug, $table, $column) > 0) {
            $i = 1;
            $new_slug = $slug . '-' . $i;
            while ($this->_check_table($new_slug, $table, $column) > 0) {
                ++$i;
                $new_slug = $slug . '-' . $i;
            }

            return $new_slug;
        }

        return $slug;
    }

    protected function _check_table($slug, $table, $column, $id = null)
    {
        $db = db_connect();
        if (null === $id) {
            $q = $db->table($table)->where($this->primary_key . ' !=', $id);
        }

        $q = $db->table($table)->where($column, $slug);

        return $q->countAllResults();
    }
}
