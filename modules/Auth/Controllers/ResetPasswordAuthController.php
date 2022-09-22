<?php

namespace Modules\Auth\Controllers;

use Modules\Auth\Events\Reset;
use Modules\Auth\Models\AuthModel;

class ResetPasswordAuthController extends BaseAuthController
{
    /**
     * Displays the Reset Password form.
     */
    public function resetPassword()
    {
        if (null === $this->config->activeResetter) {
            return redirect()->route('login')->with('error', lang('Auth.forgotDisabled'));
        }

        $token = $this->request->getGet('token');
        $username = $this->request->getGet('username');

        if (!$token) {
            return redirect()->route('forgot')->with('error', lang('Auth.errorResetTokenInvalid'));
        }

        $this->data['head_title'] = 'Reset Password - ' . $this->settings->info->site_title;
        $this->data['token'] = $token;
        $this->data['username'] = $username;

        return $this->_render($this->config->views['reset'], $this->data);
    }

    /**
     * Verifies the code with the email and saves the new password,
     * if they all pass validation.
     *
     * @return mixed
     */
    public function attemptReset()
    {
        if (null === $this->config->activeResetter) {
            return redirect()->route('login')->with('error', lang('Auth.forgotDisabled'));
        }

        if (!$this->request->getPost('token')) {
            return redirect()->route('forgot')->with('error', lang('Auth.errorResetTokenInvalid'));
        }

        $authModel = new AuthModel();

        // First things first - log the reset attempt.
        $authModel->logResetAttempt(
            $this->request->getPost('username'),
            $this->request->getPost('token'),
            $this->request->getIPAddress(),
            (string) $this->request->getUserAgent()
        );

        $rules = [
            'token' => 'required',
            'password' => 'required',
            'password_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // get account's auth details

        $auth = $authModel->where('reset_hash', $this->request->getPost('token'))->first();

        if (is_null($auth)) {
            return redirect()->back()->with('error', lang('Auth.forgotNoAccount'));
        }

        // Reset token still valid?
        if (!empty($auth->reset_expires) && time() > $auth->reset_expires->getTimestamp()) {
            return redirect()->back()->withInput()->with('error', lang('Auth.resetTokenExpired'));
        }

        // Success! Save the new password, and cleanup the reset hash.
        $auth->password = $this->request->getPost('password');
        $auth->reset_hash = null;
        $auth->reset_at = date('Y-m-d H:i:s');
        $auth->reset_expires = null;
        $auth->force_pass_reset = false;
        $authModel->save($auth);

        // trigger reset event
        (new Reset($auth))->handle();

        return redirect()->route('login')->with('message', lang('Auth.resetSuccess'));
    }
}
