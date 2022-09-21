<?php

namespace Modules\Auth\Controllers;

use Modules\Auth\Events\Forgot;
use Modules\Auth\Models\AuthModel;

class ForgotPasswordAuthController extends BaseAuthController
{
    /**
     * Displays the forgot password form.
     */
    public function forgotPassword()
    {
        if (null === $this->config->activeResetter) {
            return redirect()->route('login')->with('error', lang('Auth.forgotDisabled'));
        }

        $this->data['head_title'] = 'Forgot Password - ' . $this->settings->info->site_title;

        return $this->_render($this->config->views['forgot'], $this->data);
    }

    /**
     * Attempts to find a user account with that password
     * and send password reset instructions to them.
     */
    public function attemptForgot()
    {
        if (null === $this->config->activeResetter) {
            return redirect()->route('login')->with('error', lang('Auth.forgotDisabled'));
        }

        $rules = [
            'identity' => [
                'label' => lang('Auth.identity'),
                'rules' => 'required',
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $auth = (new AuthModel())->where('identity', $this->request->getVar('identity'))->first();

        if (is_null($auth)) {
            return redirect()->back()->with('error', lang('Auth.forgotNoAccount'));
        }

        // check if auth provider is none other than local
        if ($auth->oauth_provider !== "local") {
            return redirect()->back()->with('error', lang('Auth.forgotDisabled'));
        }

        // generate reset hash
        $auth->generateResetHash();

        // Save the reset hash
        (new AuthModel())->save($auth);

        $resetter = service('resetter');

        $sent = $resetter->send(user($auth->user_id), $auth);

        if (!$sent) {
            return redirect()->back()->withInput()->with('error', $resetter->error() ?? lang('Auth.unknownError'));
        }

        // trigger forgot event
        (new Forgot($auth))->handle();

        return redirect()->back()->withInput()->with('message', lang('Auth.forgotEmailSent'));
    }
}
