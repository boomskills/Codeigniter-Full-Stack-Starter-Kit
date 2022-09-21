<?php

namespace App\Repositories;

use App\Models\PostModel;

/**
 * User Stats.
 */
class PostRepository extends BaseRepository
{
    protected $postModel;

    public function __construct()
    {
        parent::__construct();
        $this->postModel = new PostModel();
    }


    /**
     * Get most new posts for this week.
     *
     * @param mixed $page
     * @param mixed $limit
     */
    public function getThisWeek($page = 1, $limit = 0)
    {
        $this->db->reconnect();
        $this->db->transBegin();

        if ($page < 1) {
            $page = 1;
        }

        $offset = ($page - 1) * $limit;

        $dateNow = date('Y-m-d');
        $lastWeek = date('Y-m-d', strtotime('last week monday'));

        $q = $this->db->table('posts');

        $result = $q->select('id')->getWhere(['posts', ['create_at <=' => $dateNow, 'create_at >=' => $lastWeek]], $limit, $offset);

        if (count($result->getResult()) > 0) {
            $ids = [];
            foreach ($result->getResult() as $row) {
                $ids[] = $row->news_id;
            }

            $result = $q->whereIn('id', $ids)->orderBy('view', 'DESC')->get();
        } else {
            return false;
        }

        if (false === $this->db->transStatus()) {
            $this->db->transRollback();

            return false;
        }
        $this->db->transCommit();

        return $result->getResult(\App\Entities\Post::class);

        return false;
    }

    /**
     * Returns ids of post categories
     *
     * @param null|mixed $postId
     */
    public function getCategoryIds($postId = null)
    {
        $result = $this->db->table('category_posts')->select('category_id')->where('post_id', $postId)->get()->getResult();

        $data = [];

        if (count($result) > 0) {
            foreach ($result as $r) {
                array_push($data, $r->category_id);
            }
        }

        return $data;
    }

    /**
     * Saves to post categories
     *
     * @param null|mixed $postId
     * @param mixed      $data
     */
    public function saveCategoryPosts($postId = null, $ids = [])
    {
        if (!$ids) return;
        // delete older data
        $this->db->table('category_posts')->where('post_id', $postId)->delete();

        $data = [];

        foreach ($ids as $id) {
            $data[] = [
                'post_id' => $postId,
                'category_id' => $id,
            ];
        }

        return $this->db->table('category_posts')->insertBatch($data);
    }
}
