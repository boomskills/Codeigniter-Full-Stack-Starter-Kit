<?php

namespace App\Entities;

use App\Models\PostModel;
use App\Models\UserModel;
use App\Models\DocumentModel;
use Modules\Auth\Traits\HasAuth;

/**
 * User entity
 */
class User extends BaseEntity
{

    use HasAuth;

    /**
     * @return mixed
     */
    public function posts()
    {
        return (new PostModel())->where('user_id', $this->id)->orderBy('id', 'DESC')->findAll();
    }

    public function documents()
    {
        return (new DocumentModel())->where('documentable_id', $this->id)->where('documentable_type', (new UserModel())->getEntityType())->find();
    }
}
