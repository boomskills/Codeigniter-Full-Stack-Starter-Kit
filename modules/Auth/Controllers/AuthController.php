<?php

namespace Modules\Auth\Controllers;

use App\Libraries\User;
use App\Models\UserModel;
use App\Utils\UnlinkFile;
use App\Libraries\Password;
use CodeIgniter\API\ResponseTrait;
use Modules\Auth\Models\AuthModel;

class AuthController extends BaseAuthController
{
    use ResponseTrait;
    protected $userModel;
    protected $authModel;
    protected $user;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new UserModel();
        $this->authModel = new AuthModel();
        $this->user = new User(auth_id());
    }

    /**
     * Update account.
     */
    public function attemptUpdate()
    {
        // prevent user from updating their password on this route
        if ($this->request->getVar('password') || $this->request->getVar('password_confirm')) {
            return redirect()->back()->withInput()->with('error', lang('Error.error_176'));
        }

        // phone validation
        if ($this->request->getVar('phone')) {
            if (!$this->validate([
                'phone' => 'min_length[10]|max_length[20]',
            ], [
                'phone' => [
                    'min_length' => 'Phone is invalid! Provide a valid Namibian phone number.',
                    'max_length' => 'Phone is invalid! Provide a valid Namibian phone number.',
                ],
            ])) {
                return redirect()->back()->withInput()->with('errors', $this->validator->errors);
            }
        }

        // update account
        if (!$this->userModel->update($this->user->info->id, [
            'name' => $this->request->getVar('name') ?: $this->user->info->name,
            'phone' => $this->request->getVar('phone') ?: $this->user->info->phone,
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        return redirect()->back()->withInput()->with('success', lang('Success.success_23'));
    }

    /**
     * Change account password.
     */
    public function attemptChangePassword()
    {
        // Validate current passwords since they can only be validated properly here
        if (!$this->validate([
            'current_password' => 'required|min_length[8]',
        ], [
            'current_password' => [
                'required' => 'Current password is required.',
                'min_length' => 'Current password is too short.',
            ],
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Validate passwords since they can only be validated properly here
        $rules = [
            'password' => 'required|strong_password',
            'password_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules, [
            'password_confirm' => [
                'matches' => 'Password confirmation do not match.',
            ],
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $currentPassword = $this->request->getVar('current_password');
        $newPassword = $this->request->getVar('password');

        $auth = $this->authModel->find(auth_id());

        // Now, try matching the passwords.
        if (!Password::verify($currentPassword, $auth->password_hash)) {
            return redirect()->back()->withInput()->with('error', lang('Auth.currentPasswordWrong'));
        }

        // error if user is password is the same
        if (Password::verify($newPassword, $auth->password_hash)) {
            return redirect()->back()->withInput()->with('error', lang('Auth.errorPasswordChange'));
        }

        // Success! Save the new password
        $auth->password = $newPassword;

        if (!$this->authModel->save($auth)) {
            // error send back
            return redirect()->back()->withInput()->with('errors', $this->authModel->errors());
        }

        // logout user
        $this->auth->logout();

        return redirect()->to(site_url('auth/login'))->withInput()->with('message', "Password changed successfully. Login with your new password");
    }

    /**
     * Change account email.
     */
    public function attemptChangeEmail()
    {
        // error if account is inactive
        if (!$this->auth->active) {
            return redirect()->back()->withInput()->with('error', lang('Error.error_174'));
        }

        if (!$this->validate([
            'new_email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->errors);
        }

        $newEmail = $this->request->getVar('new_email');

        $user = user($this->user->info->id);

        // set new email
        $user->email = $newEmail;

        // save
        if (!$this->userModel->save($user)) {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        // auth
        $auth = $this->authModel->find(auth_id());

        // deactivate the account
        $auth = $auth->deactivate();
        $this->authModel->save($auth);

        // send activation email
        $activator = service('activator');
        $sent = $activator->send($user, $auth);

        if (!$sent) {
            return redirect()->back()->withInput()->with('errors', $activator->error() ?? lang('Auth.unknownError'));
        }

        return redirect()->back()->withInput()->with('success', lang('Success.success_23'));
    }

    /**
     * Change Avatar profile picture.
     */
    public function attemptChangeAvatar()
    {
        if (!$this->validate([
            'avatar' => 'required|is_image',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validate->errors);
        }

        // delete old picture if available
        if ($this->user->info->avatar) {
            (new UnlinkFile($this->user->info->avatar))->handle();
        }

        $avatar = $this->request->getFile('avatar');
        $file_path = '';

        if ($avatar->isValid() && !$avatar->hasMoved()) {
            $path = 'uploads/' . $avatar->store($this->user->info->account_number);
            $file_path = $path;
        }

        if ($this->userModel->update($this->user->info->id, [
            'avatar' => $file_path,
        ])) {
            return redirect()->back()->withInput()->with('success', lang('Success.success_64'));
        }

        return redirect()->back()->withInput()->with('error', lang('Success.invalid_file'));
    }

    /**
     * Danger zone
     */
    public function attemptDelete()
    {
        return redirect()->back()->withInput()->with('errors', "Error cannot delete account");
    }
}
