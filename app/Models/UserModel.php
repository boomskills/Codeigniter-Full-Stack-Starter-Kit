<?php

namespace App\Models;

use App\Entities\User;

class UserModel extends BaseModel
{
    protected $table = 'users';
    protected $returnType = User::class;
    protected $allowedFields = [
        'name',
        'account_id',
        'email',
        'password'
    ];

    // Callbacks
    protected $afterInsert = [];
    protected $beforeInsert = [];
    protected $afterDelete = [];

    public function getEntityType()
    {
        return self::class;
    }
}
