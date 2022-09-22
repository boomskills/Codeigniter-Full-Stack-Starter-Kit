<?php

namespace App\Controllers;

use App\Libraries\User;
use App\Libraries\Settings;
use App\Models\CategoryModel;
use App\Models\PostModel as Post;

abstract class ClientBaseController extends BaseController
{

    protected $postModel;
    protected $user;

    public function __construct()
    {

        helper(['auth']);
        $this->settings = new Settings();
        $this->postModel = new Post();

        $this->data['head_title'] = $this->settings->info->site_title . ' | ' . $this->settings->info->site_heading;
        $this->data['meta_description'] = $this->settings->info->meta_description;
        $this->data['meta_keywords'] = $this->settings->info->meta_keywords;
        $this->data['message'] = '';

        $this->data['site_title'] = "Codeigniter Full-Stack  Starter Kit";
        $this->data['categories'] = $this->categories();
        $this->data['posts'] = $this->posts();
        $this->data['user'] = null;

        // is user logged in
        if (logged_in()) {
            $this->data['user'] = new User(auth_id());
            $this->user = $this->data['user'];
        }
    }

    /**
     * Renderer view.
     *
     * @param null|mixed $data
     * @param null|mixed $content
     */
    protected function render_layout($content = null)
    {
        echo view('layout/content', $content);
    }


    /**
     * Posts.
     */
    private function posts()
    {
        return $this->postModel->where('status', 'published')->orderBy('created_at', 'DESC')->findAll();
    }


    /**
     * Load categories.
     */
    private function categories()
    {
        return (new CategoryModel())->orderBy('title', "ASC")->findAll();
    }
}
