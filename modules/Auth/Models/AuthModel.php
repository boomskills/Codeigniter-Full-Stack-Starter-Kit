<?php

namespace Modules\Auth\Models;

use App\Models\BaseModel;
use Modules\Auth\Entities\Auth;

class AuthModel extends BaseModel
{
    protected $table = 'auths';
    protected $primaryKey = 'user_id';
    protected $useAutoIncrement = false;

    protected $returnType = Auth::class;

    protected $allowedFields = [
        'oauth_provider',
        'oauth_token',
        'oauth_id',
        'user_id',
        'username',
        'password_hash',
        'reset_hash',
        'reset_at',
        'reset_expires',
        'activate_hash',
        'status',
        'status_message',
        'active',
        'force_pass_reset',
        'permissions',
        'ip_address',
    ];

    protected $validationRules = [
        'user_id' => 'required|is_unique[auths.user_id,user_id,{user_id}]|is_not_unique[users.id,id,{id}]',
        'username' => 'required|min_length[3]|max_length[100]|is_unique[auths.username,user_id,{user_id}]',
        'password_hash' => 'required',
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;

    /**
     * Logs a password reset attempt for posterity sake.
     */
    public function logResetAttempt(string $identity, string $token = null, string $ipAddress = null, string $userAgent = null)
    {
        $this->db->table('auth_reset_attempts')->insert([
            'identity' => $identity,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'token' => $token,
        ]);
    }

    /**
     * Logs an activation attempt for posterity sake.
     */
    public function logActivationAttempt(string $token = null, string $ipAddress = null, string $userAgent = null)
    {
        $this->db->table('auth_activation_attempts')->insert([
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'token' => $token,
        ]);
    }
}
