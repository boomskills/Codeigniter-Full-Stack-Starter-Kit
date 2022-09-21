<?php

namespace App\Entities;

use App\Models\AccountModel;

/**
 * User entity
 */
class User extends BaseEntity
{

    /**
     * A user must have an account
     *
     * @return App\Entities\Account
     */
    public function account()
    {
        return (new AccountModel())->find($this->account_id);
    }
}
