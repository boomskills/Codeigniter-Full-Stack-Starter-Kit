<?php

namespace Modules\Auth\Controllers;

use Google\Client;
use App\Entities\User;
use App\Entities\Profile;
use App\Models\ClubModel;
use App\Models\PageModel;
use App\Models\UserModel;
use App\Libraries\Slugify;
use App\Models\ProfileModel;
use Modules\Auth\Entities\Auth;
use Modules\Auth\Events\SignUp;
use Modules\Auth\Models\AuthModel;

class RegisterAuthController extends BaseAuthController
{
    protected $errors = [
        'firstName' => [
            'required' => 'First name is required',
        ],

        'lastName' => [
            'required' => 'Last name is required',
        ],

        'gender' => [
            'required' => 'You must choose your gender',
        ],

        'birthday' => [
            'required' => 'please provide a date of birth',
            'valid_date' => 'invalid date of birth',
        ],

        'phone' => [
            'required' => 'Phone number is required',
            'min_length' => 'Please provide a valid Namibian phone number.',
        ],
    ];

    /**
     * Displays the user registration page.
     */
    public function register()
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

        // check if already logged in.
        if ($this->auth->check()) {
            return redirect()->back();
        }

        // Check if registration is allowed
        if (!$this->config->allowRegistration) {
            return redirect()->back()->withInput()->with('error', lang('Auth.registerDisabled'));
        }

        $registerPage = (new PageModel())->where('id', 13)->first();

        $this->data['googleLoginUrl'] = $googleClient->createAuthUrl();
        $this->data['head_title'] = 'Sign up - ' . $this->settings->info->site_title;
        $this->data['page'] = $registerPage;
        $this->data['clubs'] = (new ClubModel())->findAll();

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
        $profileModel = new ProfileModel();
        $authModel = new AuthModel();

        // Validate basics first since some password rules rely on these fields
        $rules = [
            'identity' => 'required|is_unique[authentications.identity]',
            'email' => 'required|valid_email|is_unique[users.email]',
        ];

        if (!$this->validate($rules, [
            'identity' => [
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
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'gender' => 'required',
            'birthday' => 'required|valid_date[Y-m-d]',
            'phone' => 'required|min_length[10]|max_length[20]',
        ];

        // Validate profile required fields since they can only be validated properly here
        if (!$this->validate($rules, $this->errors)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // profile required info
        $firstName = $this->request->getVar('firstName');
        $lastName = $this->request->getVar('lastName');
        // create selector
        $selector = (new Slugify())->slug_unique($firstName . ' ' . $lastName, 'users', 'selector');

        // STEP 1) create user

        $user = new User();

        $user->fill([
            'name' => $firstName . ' ' . $lastName,
            'email' => $this->request->getVar('email'),
            'phone' => $this->request->getVar('phone'),
            'selector' => $selector
        ]);

        // Ensure default role gets assigned
        $users = $userModel->withRole($this->config->defaultUserRole);

        $newUserId = $userModel->insert($user, true);

        if (!$newUserId) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        // STEP 2) Create user profile
        $profile = new Profile();

        $profile->fill([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'gender' => $this->request->getVar('gender'),
            'birthday' => date('Y/m/d', strtotime($this->request->getVar('birthday'))),
            'email_address' => $this->request->getVar('email'),
            'phone_number' => $this->request->getVar('phone'),
            'user_id' => $newUserId,
            'type' => 'primary',
        ]);

        // Save user profile
        if (!$profileModel->save($profile)) {
            //in case the profile creation fails, abort the mission
            $users->delete($newUserId);
            // redirect back to register page
            return redirect()->back()->withInput()->with('errors', $profileModel->errors());
        }

        // STEP 3) Authentication

        $auth = new Auth();

        $auth->fill([
            "oauth_provider" => "local",
            'password' => $this->request->getVar('password'),
            'identity' => $this->request->getVar('identity'),
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

        // add user to club
        if ($this->request->getVar('club_id')) {
            db_connect()->table('club_members')->insert([
                'club_id' => $this->request->getVar('club_id'),
                'member_id' => $newUserId
            ]);
        }

        // trigger signup event
        (new SignUp($auth))->handle();

        // Success!
        return redirect()->route('login')->with('message', lang('Auth.registerSuccess'));
    }
}
