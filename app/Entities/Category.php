<?php

namespace App\Entities;

use App\Models\PostModel;

class Category extends BaseEntity
{

    public function posts()
    {
        $ids = db_connect()->table('category_posts')->select('post_id')->where('category_id', $this->id)->get()->getResult();

        $data = [];

        if ($ids) {

            foreach ($ids as $id) {

                $post = (new PostModel())->find($id->post_id);

                array_push($data, $post);
            }
        }

        return $data;
    }
}
