<?php

namespace Modules\Admin\Controllers;

use App\Models\PostModel;
use App\Utils\UnlinkFile;
use App\Models\CategoryModel;
use App\Events\Post\PostWasCreated;
use App\Events\Post\PostWasDeleted;
use App\Events\Post\PostWasUpdated;
use App\Repositories\PostRepository;
use App\Events\Post\PostWasPublished;

class PostController extends BaseAdminController
{
    protected $postModel;
    protected $post_repo;

    public function __construct()
    {
        parent::__construct();
        $this->postModel = new PostModel();
        $this->post_repo = new PostRepository();
    }

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return mixed
     */
    public function index()
    {
        $this->data['posts'] = $this->postModel->findAll();
        $this->data['panel_title'] = 'Posts';

        return $this->_render($this->admin->views['post']['index'], $this->data);
    }

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return mixed
     */
    public function new()
    {
        $this->data['panel_title'] = 'Create New Post';
        $this->data['categories'] = (new CategoryModel())->findAll();

        return $this->_render($this->admin->views['post']['new'], $this->data);
    }


    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return mixed
     */
    public function create()
    {

        if (!$this->validate([
            'title' => 'required|string',
            'short_description' => 'required|string',
            'description' => 'required',
        ], [
            'title' => [
                'required' => 'Post Title is required',
            ],
            'short_description' => [
                'required' => 'Please provide a short description os your post.',
            ],
            'description' => [
                'required' => 'Post description is required.',
            ],
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }


        $title = $this->request->getVar('title');
        $categories = $this->request->getVar('categories');

        // images
        $postImage = '';

        $thumbnail = $this->request->getFile('thumbnail');

        if ($thumbnail && $thumbnail->isValid() && !$thumbnail->hasMoved()) {
            $path = 'uploads/' . $thumbnail->store(strtolower(url_title($title)) . '-' . date('Y-m-d'));
            $postImage = $path;
        }

        $status = $this->request->getVar('status');

        $createOne = $this->factory->createOne($this->postModel, [
            'slug' => strtolower(url_title($title)),
            'title' => $title,
            'short_description' => $this->request->getVar('short_description'),
            'description' => $this->request->getVar('description'),
            'user_id' => $this->user->info->id,
            'thumbnail' => $postImage,
            'status' => $status,
        ]);

        if ($createOne['success']) {
            // fire event
            (new PostWasCreated($this->postModel->find($createOne['data'])))->handle();

            // save post category posts
            $this->post_repo->saveCategoryPosts($createOne['data'], $categories);
            return redirect()->back()->withInput()->with('success', $createOne['message']);
        }

        return redirect()->back()->withInput()->with('error', $createOne['message']);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        $model = $this->postModel->find($id);

        if (!$model) {
            return $this->template->__admin_error(lang('Error.postNotFound'), $this->data);
        }

        $this->data['panel_title'] = $model->title;
        $this->data['post'] = $model;
        $this->data['categories'] = (new CategoryModel())->findAll();
        $this->data['category_ids'] = $this->post_repo->getCategoryIds($id);

        return $this->_render($this->admin->views['post']['edit'], $this->data);
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function update($id = null)
    {

        $post = $this->postModel->find($id);

        if (!$post) {
            return $this->template->__admin_error(lang('Error.postNotFound'));
        }

        $title = $this->request->getVar('title');
        $categories = $this->request->getVar('categories');

        $postImage = $post->thumbnail;

        // images
        $thumbnail = $this->request->getFile('thumbnail');

        if ($thumbnail && $thumbnail->isValid() && !$thumbnail->hasMoved()) {
            // delete any file associated with this result
            if ($post->thumbnail) {
                (new UnlinkFile($post->thumbnail))->handle();
            }
            $path = 'uploads/' . $thumbnail->store(strtolower(url_title($title)) . '-' . date('Y-m-d'));
            $postImage = $path;
        }

        $status = $this->request->getVar('status');

        $updateOne = $this->factory->updateOne($this->postModel, [
            'slug' => strtolower(url_title($title)),
            'title' => $title,
            'short_description' => $this->request->getVar('short_description'),
            'description' => $this->request->getVar('description'),
            'thumbnail' => $postImage,
            'status' => $status,
        ], $post->id);

        if ($updateOne['success']) {
            // save post category posts
            $this->post_repo->saveCategoryPosts($id, $categories);
            // fire event
            (new PostWasUpdated($post))->handle();
            return redirect()->back()->withInput()->with('success', $updateOne['message']);
        }

        return redirect()->back()->withInput()->with('error', $updateOne['message']);
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function delete($id = null)
    {

        $post = $this->postModel->find($id);

        if (!$post) {
            return $this->template->__admin_error(lang('Error.postNotFound'));
        }

        // delete any file associated with this result
        if ($post->thumbnail) {
            (new UnlinkFile($post->thumbnail))->handle();
        }

        $deleteOne = $this->factory->deleteOne($this->postModel, $post->id);

        if ($deleteOne['success']) {
            // fire deleted event
            (new PostWasDeleted($post))->handle();
            return redirect()->back()->withInput()->with('success', $deleteOne['message']);
        }

        return redirect()->back()->withInput()->with('error', $deleteOne['message']);
    }

    /**
     * Publish post.
     *
     * @param null|mixed $postId
     */
    public function updatePostStatus($postId = null)
    {
        $post = $this->postModel->find($postId);

        if (!$post) {
            return $this->template->__admin_error(lang('Error.postNotFound'));
        }

        $message = lang('Success.success_60');

        // unpublish if already published
        if ($post->isPublished()) {
            $publish = $post->unpublish();

            if ($this->postModel->save($publish)) {
                return redirect()->back()->withInput()->with('success', $message);
            };
        }

        // publish if not published
        if (!$post->isPublished()) {
            $message = "Post has been unpublished";
            $publish = $post->publish();
            $publish->published_by = $this->user->info->id;

            if ($this->postModel->save($publish)) {
                // fire published event
                (new PostWasPublished($post))->handle();
                return redirect()->back()->withInput()->with('success', $message);
            };
        }

        return redirect()->back()->withInput()->with('success', $this->postModel->errors());
    }
}
