<?php

namespace App\Controllers;

use App\Models\PostModel;

class ArticleController extends ClientBaseController
{
    protected $articleModel;

    public function __construct()
    {
        parent::__construct();
        $this->articleModel = new PostModel();
    }

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return mixed
     */
    public function index()
    {
        $this->data['articles'] = $this->articleModel->findAll();
        $this->data['head_title'] = 'News/Blogs';
        $this->data['page'] = 'article/index';
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
        $article = $this->articleModel->find($id);

        if (is_null($article)) {
            return $this->template->__client_error(lang('Error.postNotFound'));
        }

        $this->data['article'] = $article;
        $this->data['head_title'] = $article->title;
        $this->data['meta_description'] = $article->short_description;
        $this->data['url'] = site_url(sprintf(ARTICLE_DETAIL_PATH, $article->post_number, to_slug($article->title), $article->id));
        $this->data['images'] = renderImage($article->cover_image);
        $this->data['category'] = $article->categories();
        $this->data['page'] = 'article/show';
        $this->articleModel->save($article->updateView()); // update views
        $this->render_layout($this->data);
    }
}
