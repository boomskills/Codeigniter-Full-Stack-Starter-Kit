<?php

namespace Modules\Auth\Controllers;

use Google\Client;
use App\Entities\User;
use App\Models\UserModel;
use Modules\Auth\Entities\Auth;
use Modules\Auth\Events\SignUp;
use Modules\Auth\Models\AuthModel;

class RegisterAuthController extends BaseAuthController
{
    protected $errors = [
        'name' => [
            'required' => 'First name is required',
        ],
    ];

    /**
     * Displays the user registration page.
     */
    public function register()
    {

        // Google Client Configuration
        // $googleClient = new Client();
        // $googleClient->setApplicationName($this->settings->info->site_title);
        // $googleClient->setClientId(getenv("GOOGLE_CLIENT_ID"));
        // $googleClient->setClientSecret(getenv("GOOGLE_CLIENT_SECRET"));
        // $googleClient->setRedirectUri(getenv("GOOGLE_REDIRECT_URI"));
        // $googleClient->setScopes(
        //     [
        //         'https://www.googleapis.com/auth/userinfo.email',
        //         'https://www.googleapis.com/auth/userinfo.profile',
        //     ]
        // );

        // check if already logged in.
        if ($this->auth->check()) {
            return redirect()->back();
        }

        // Check if registration is allowed
        if (!$this->config->allowRegistration) {
            return redirect()->back()->withInput()->with('error', lang('Auth.registerDisabled'));
        }

        //$this->data['googleLoginUrl'] = $googleClient->createAuthUrl();
        $this->data['head_title'] = 'Sign up - ' . $this->settings->info->site_title;

        return $this->_render($this->config->views['register'], $this->data);
    }

    /**
     * Attempt to register a new user.
     */
    public function attemptRegister()
    {
        // Check if registration is allowed
        if (!$this->config->allowRegistration) {
            return redirect()->back()->withInput()->with('error', lang('Auth.registerDisabled'));
        }

        // models variables
        $userModel = new UserModel();
        $authModel = new AuthModel();

        // Validate basics first since some password rules rely on these fields
        $rules = [
            'username' => 'required|is_unique[auths.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
        ];

        if (!$this->validate($rules, [
            'username' => [
                'required' => 'You must choose a username.',
                'is_unique' => 'The Username is already in use.',
            ],
            'email' => [
                'valid_email' => 'Please check the Email field. It does not appear to be valid.',
                'is_unique' => 'Email address is already in use.',
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
            'password' => [
                'required' => 'Please a password',
            ],
            'password_confirm' => [
                'matches' => 'Password confirmation do not match',
            ],
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $rules = [
            'name' => 'required|string',
        ];

        // Validate profile required fields since they can only be validated properly here
        if (!$this->validate($rules, $this->errors)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = new User();

        $user->fill([
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
        ]);

        // Ensure default role gets assigned
        $users = $userModel->withRole($this->config->defaultUserRole);

        $newUserId = $userModel->insert($user, true);

        if (!$newUserId) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        $auth = new Auth();

        $auth->fill([
            "oauth_provider" => "local",
            'username' => $this->request->getVar('username'),
            'password' => $this->request->getVar('password'),
            'user_id' => $newUserId,
            'ip_address' => $this->request->getIPAddress(),
        ]);

        null === $this->config->requireActivation ? $auth->activate() : $auth->generateActivateHash();

        if (!$authModel->save($auth)) {
            //in case the profile creation fails, delete the user created above
            $users->delete($newUserId);
            // redirect back to register page
            return redirect()->back()->withInput()->with('errors', $authModel->errors());
        }

        if (null !== $this->config->requireActivation) {
            $activator = service('activator');
            $sent = $activator->send($user, $auth);

            if (!$sent) {
                return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
            }
        }

        // trigger signup event
        (new SignUp($auth))->handle();

        // Success!
        return redirect()->route('login')->with('message', lang('Auth.registerSuccess'));
    }
}
