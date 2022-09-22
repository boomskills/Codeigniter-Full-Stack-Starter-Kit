<?php

namespace App\Commands;

use App\Entities\User;
use CodeIgniter\CLI\CLI;
use App\Models\UserModel;
use Modules\Auth\Entities\Auth;
use CodeIgniter\CLI\BaseCommand;
use Modules\Auth\Models\AuthModel;

class CreateUser extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Auth';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'auth:create-user';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Creates an admin user.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'auth:create-user';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        // model variables
        $userModel = new UserModel();
        $authModel = new AuthModel();

        // STEP 1) Create user
        $user = new User();
        $user->fill([
            'name' => 'Gerald Kandonga',
            'email' => 'fillipusgeraldo@gmail.com',
        ]);

        // Ensure default role gets assigned
        $userModel = $userModel->withRole('superadmin');

        // create user
        $newUserId = $userModel->insert($user, true);

        if (!$newUserId) {
            foreach ($userModel->errors() as $message) {
                CLI::write($message, 'red');
            }
        }

        // STEP 2) Create Authentication
        $auth = new Auth();
        $auth->fill([
            'password' => 'password',
            'username' => 'admin',
            'user_id' => $newUserId,
            'ip_address' => \Config\Services::request()->getIPAddress(),
            'active' => 1,
        ]);

        if (!$authModel->save($auth)) {
            //in case the profile creation fails, delete the user created above
            $userModel->delete($newUserId);

            foreach ($authModel->errors() as $message) {
                CLI::write($message, 'red');
            }
        }

        // Success!
        CLI::write(lang('Auth.registerSuccess'), 'green');
    }
}
