<?php

namespace App\Models;

use App\Entities\User;
use Modules\Auth\Authorization\RoleModel;

class UserModel extends BaseModel
{
    protected $table = 'users';
    protected $returnType = User::class;
    protected $allowedFields = [
        'name',
        'email'
    ];

    // Callbacks
    protected $afterInsert = [
        'addToRole',
    ];

    protected $beforeInsert = [];
    protected $afterDelete = [];

    /**
     * The id of a role to assign.
     * Set internally by withRole.
     *
     * @var null|int
     */
    protected $assignRole;


    /**
     * Sets the role to assign any users created.
     *
     * @return $this
     */
    public function withRole(string $roleSlug)
    {
        $role = $this->db->table('roles')->where('slug', $roleSlug)->get()->getFirstRow();

        $this->assignRole = $role->id;

        return $this;
    }

    /**
     * Clears the role to assign to newly created users.
     *
     * @return $this
     */
    public function clearRole()
    {
        $this->assignRole = null;

        return $this;
    }

    /**
     * If a default role is assigned in Config\Auth, will
     * add this user to that role. Will do nothing
     * if the role cannot be found.
     *
     * @param mixed $data
     *
     * @return mixed
     */
    protected function addToRole($data)
    {
        if (is_numeric($this->assignRole)) {
            (new RoleModel())->addUserToRole($data['id'], $this->assignRole);
        }

        return $data;
    }

    public function getEntityType()
    {
        return self::class;
    }
}
