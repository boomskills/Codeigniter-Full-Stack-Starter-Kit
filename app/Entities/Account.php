<?php

namespace App\Entities;

use App\Models\UserModel;

/**
 * Account entity
 */
class Account extends BaseEntity
{
    /**
     * An account must belong to a user
     *
     * @return App\Entities\User
     */
    public function user()
    {
        return (new UserModel())->find($this->user_id);
    }
}
