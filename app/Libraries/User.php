<?php

namespace App\Libraries;

/**
 * Returns a complete user account with profile and settings.
 */
class User
{
    public $info = [];
    protected $users_Table = 'users';
    protected $auth_Table = 'auths';

    /**
     * @param null|int $userId
     */
    public function __construct(int $userId = 0)
    {
        $select = "
			{$this->users_Table}.id,
			{$this->users_Table}.name,
			{$this->users_Table}.email,
            {$this->auth_Table}.username,
            {$this->auth_Table}.ip_address,
            {$this->auth_Table}.status,
            {$this->auth_Table}.status_message,
            {$this->auth_Table}.active,
            {$this->auth_Table}.online_timestamp,
	    ";

        $user = db_connect()->table($this->users_Table)->select($select)
            ->where("{$this->users_Table}.id", $userId)
            ->join("{$this->auth_Table}", "{$this->auth_Table}.user_id = {$this->users_Table}.id", 'left outer')
            ->get()->getFirstRow();

        if (!is_null($user)) {
            $this->info = $user;
        }
    }
}
