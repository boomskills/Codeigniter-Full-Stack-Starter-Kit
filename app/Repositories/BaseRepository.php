<?php

namespace App\Repositories;

use App\Libraries\Factory;
use App\Libraries\Settings;
use App\Libraries\Slug;
use App\Utils\Traits\SavesDocuments;

class BaseRepository
{
    use SavesDocuments;
    protected $factory;
    protected $slug;
    protected $session;
    protected $settings;
    protected $db;

    public function __construct()
    {
        $this->factory = new Factory();
        $this->session = session();
        $this->settings = new Settings();
        $this->slug = new Slug(['replacement' => '-']);
        $this->db = \Config\Database::connect();
    }
}
