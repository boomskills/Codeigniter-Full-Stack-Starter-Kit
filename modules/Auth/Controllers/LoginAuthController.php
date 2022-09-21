<?php

namespace Modules\Auth\Controllers;

use Google\Client;

class LoginAuthController extends BaseAuthController
{
    /**
     * Displays the login form, or redirects
     * the user to their destination/home if
     * they are already logged in.
     */
    public function login()
    {

        // Google Client Configuration
        $googleClient = new Client();
        $googleClient->setApplicationName($this->settings->info->site_title);
        $googleClient->setClientId(getenv("GOOGLE_CLIENT_ID"));
        $googleClient->setClientSecret(getenv("GOOGLE_CLIENT_SECRET"));
        $googleClient->setRedirectUri(getenv("GOOGLE_REDIRECT_URI"));
        $googleClient->setScopes(
            [
                'https://www.googleapis.com/auth/userinfo.email',
                'https://www.googleapis.com/auth/userinfo.profile',
            ]
        );

        // No need to show a login form if the user
        // is already logged in.
        if ($this->auth->check()) {
            $redirectURL = session('redirect_url') ?? site_url('/');
            unset($_SESSION['redirect_url']);

            return redirect()->to($redirectURL);
        }

        // Set a return URL if none is specified
        $_SESSION['redirect_url'] = session('redirect_url') ?? previous_url() ?? site_url('/');

        $this->data['googleLoginUrl'] = $googleClient->createAuthUrl();
        $this->data['head_title'] = 'Login - ' . $this->settings->info->site_title;

        return $this->_render($this->config->views['login'], $this->data);
    }

    /**
     * Attempts to verify the user's credentials
     * through a POST request.
     */
    public function attemptLogin()
    {
        $rules = [
            'identity' => 'required',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $identity = $this->request->getPost('identity');
        $password = $this->request->getPost('password');
        $remember = (bool) $this->request->getPost('remember');

        // Try to log them in...
        if (!$this->auth->attempt(['identity' => $identity, 'password' => $password], $remember)) {
            // redirect back with error
            return redirect()->back()->withInput()->with('error', $this->auth->error() ?? lang('Auth.badAttempt'));
        }

        // Is the user being forced to reset their password?
        if (true === $this->auth->auth()->force_pass_reset) {
            return redirect()->to(route_to('reset-password') . '?token=' . $this->auth->auth()->reset_hash)->withCookies();
        }

        $redirectURL = session('redirect_url') ?? site_url('/');
        unset($_SESSION['redirect_url']);

        return redirect()->to($redirectURL)->withCookies()->with('message', lang('Auth.loginSuccess'));
    }
}
