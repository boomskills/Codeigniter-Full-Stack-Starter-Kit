<?php

namespace App\Entities;

use App\Models\UserModel;
use App\Models\CategoryModel;
use App\Models\DocumentModel;

class Post extends BaseEntity
{

    public function isPublished(): bool
    {
        return ("published" == $this->status ? true : false);
    }

    /**
     * Returns owner of the post.
     */
    public function user()
    {
        return (new UserModel())->find($this->user_id);
    }

    /**
     * publish post.
     *
     * @return $this
     */
    public function publish()
    {
        $this->attributes['status'] = 'published';
        $this->attributes['published_at'] = date('Y-m-d H:i:s');

        return $this;
    }

    /**
     * Unpublish post.
     *
     * @return $this
     */
    public function unpublish()
    {
        $this->attributes['status'] = 'pending';
        $this->attributes['published_at'] = null;

        return $this;
    }

    /**
     * Update views.
     *
     * @return $this
     */
    public function updateView()
    {
        $this->attributes['views'] = $this->views + 1;
        return $this;
    }

    public function documentable()
    {
        return (new DocumentModel())->documentable($this->id, 'App\\Models\\PostModel');
    }


    /**
     * categories.
     *
     * @return $this
     */
    public function categories()
    {
        $ids = db_connect()->table('category_posts')->select('category_id')->where('post_id', $this->id)->get()->getResult();

        $data = [];

        if ($ids) {

            foreach ($ids as $id) {

                $category = (new CategoryModel())->find($id->category_id);

                array_push($data, $category);
            }
        }

        return $data;
    }
}
