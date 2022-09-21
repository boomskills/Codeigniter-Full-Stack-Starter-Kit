<?php

namespace App\Models;

use App\Entities\Account;

/**
 * Account Model
 */
class AccountModel extends BaseModel
{
    protected $table = 'accounts';
    protected $returnType = Account::class;
    protected $allowedFields = [
        'name',
        'account_id',
        'user_id'
    ];

    // Callbacks
    protected $afterInsert = ['generateAccountId',];
    protected $beforeInsert = [];
    protected $afterDelete = [];

    /**
     * Generates a account number based on total available row.
     *
     * @param mixed $data
     */
    protected function generateAccountId($data)
    {
        (new AccountModel())->builder()
            ->where('id', $data['id'])
            ->set(['account_id' => makeUniqueID('account_id', 'number', date("Y"), 12)])
            ->update();

        return $data;
    }
}
