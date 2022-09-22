<?php

namespace App\Models;

use App\Entities\Post;

class PostModel extends BaseModel
{
    protected $table            = 'posts';
    protected $returnType       = Post::class;
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'post_id',
        'user_id',
        'title',
        'slug',
        'short_description',
        'thumbnail',
        'description',
        'status',
        'views',
        'published_at',
        'meta'
    ];

    // Callbacks
    protected $afterInsert = ['generatePostId',];
    protected $beforeInsert = [];
    protected $afterDelete = [];

    public function getEntityType()
    {
        return self::class;
    }

    /**
     * Generates a post id
     *
     * @param mixed $data
     */
    protected function generatePostId($data)
    {
        (new PostModel())->builder()
            ->where('id', $data['id'])
            ->set(['post_id' => makeUniqueID('posts', 'post_id', date("Y"), 6)])
            ->update();

        return $data;
    }
}
