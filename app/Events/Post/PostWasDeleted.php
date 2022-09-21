<?php

namespace App\Events\Post;

use App\Entities\Post;
use App\Events\BaseEvent;
use CodeIgniter\Events\Events;

class PostWasDeleted extends BaseEvent
{
    protected $post;
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function handle()
    {
        $this->trigger("post-was-deleted", $this->post);
    }
}
