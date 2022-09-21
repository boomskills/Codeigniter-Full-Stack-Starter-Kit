<?php

namespace App\Repositories;

class UserRepository extends BaseRepository
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Returns total users.
     */
    public function totalUsers()
    {
        $s = $this->db->table("users")->select('COUNT(*) as total_users')->where('deleted_at', null)->get();
        $r = $s->getRow();
        if (isset($r->total_users)) {
            return $r->total_users;
        }

        return 0;
    }

    /**
     * Gets recent users.
     *
     * @TODO need improvement
     */
    public function recentUsers()
    {
        $s = $this->db->table("users")->select('COUNT(*) as recent_users')->where('created_at', date('Y-m-d'))->get();
        $r = $s->getRow();
        if (isset($r->recent_users)) {
            return $r->recent_users;
        }

        return 0;
    }

    public function weeklyUsers()
    {
        $s = $this->db->table("users")->select('COUNT(*) as weekly_users')->where('created_at > DATE_SUB(NOW(), INTERVAL 1 WEEK)')->get();
        $r = $s->getRow();
        if (isset($r->weekly_users)) {
            return $r->weekly_users;
        }

        return 0;
    }
}
