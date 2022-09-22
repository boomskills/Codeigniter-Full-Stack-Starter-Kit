<?php

namespace App\Controllers;

use App\Models\PostModel;

class PostController extends ClientBaseController
{
    protected $postModel;

    public function __construct()
    {
        parent::__construct();
        $this->postModel = new PostModel();
    }

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return mixed
     */
    public function index()
    {
        $this->data['posts'] = $this->postModel->findAll();
        $this->data['head_title'] = 'Posts';
        $this->data['page'] = 'post/index';
        $this->render_layout($this->data);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $post = $this->postModel->find($id);

        if (is_null($post)) {
            return $this->template->__client_error(lang('Error.postNotFound'));
        }

        $this->data['post'] = $post;
        $this->data['head_title'] = $post->title;
        $this->data['meta_description'] = $post->short_description;
        $this->data['url'] = site_url(sprintf(POST_DETAIL_PATH, $post->post_id, slug($post->title), $post->id));
        $this->data['images'] = renderImage($post->thumbnail);
        $this->data['categories'] = $post->categories();
        $this->data['page'] = 'post/show';
        $updateView = $post->updateView();
        $this->postModel->save($updateView); // update views
        $this->render_layout($this->data);
    }
}
