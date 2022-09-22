<?php

namespace Modules\Auth\Controllers;

use Google\Client;
use App\Models\UserModel;
use Google\Service\Oauth2;
use Modules\Auth\Models\AuthModel;

class SocialLoginAuthController extends BaseAuthController
{
    /**
     * googleOauthLogin process google login.
     */
    public function googleOauthLogin()
    {
        // models variables
        $userModel = new UserModel();
        $authModel = new AuthModel();

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

        // fetch access token from google auth
        $token = $googleClient->fetchAccessTokenWithAuthCode($this->request->getVar('code'));

        // do we have a token
        if (!isset($token['error'])) {
            // set access token
            $googleClient->setAccessToken($token['access_token']);

            // get user from google auth
            $googleService = new Oauth2($googleClient);
            $googleData = $googleService->userinfo->get();
            $oauth_id = $googleData['id'];

            $firstName = $googleData['given_name'];
            $lastName = $googleData['family_name'];
            $userEmail = $googleData['email'];

            if (!$oauth_id) {
                return redirect()->back()->withInput()->with('error', lang('Error.error_32'));
            }

            // get user by email
            $authUser = $userModel->where("email", $userEmail)->first();

            // check if user exist with this social account and login
            if ($authUser) {
                $auth = $authUser->auth();
                // update user oauth
                $auth->oauth_id = $oauth_id;
                $auth->oauth_token = $token['access_token'];

                if ($authModel->save($auth)) {
                    // login user by id
                    $this->auth->loginByID($auth->user_id);

                    $redirectURL = session('redirect_url') ?? site_url('/');
                    unset($_SESSION['redirect_url']);

                    return redirect()->to($redirectURL)->withCookies()->with('message', lang('Auth.loginSuccess'));
                };

                return redirect()->back()->withInput()->with('errors', $authModel->errors() ?? lang("Error.error_96"));
            }

            // STEP 1) create user

            $user = new \App\Entities\User();

            $user->fill([
                'name' => $firstName . ' ' . $lastName,
                'email' => $userEmail,
            ]);

            // Ensure default role gets assigned
            $users = $userModel->withRole($this->config->defaultUserRole);

            $newUserId = $userModel->insert($user, true);

            if (!$newUserId) {
                return redirect()->back()->withInput()->with('errors', $users->errors());
            }


            // STEP 2) Authentication

            $auth = new \Modules\Auth\Entities\Auth();

            $auth->fill([
                'user_id' => $newUserId,
                "oauth_provider" => "google",
                "oauth_id" => $oauth_id,
                "oauth_token" => $token['access_token'],
                'password' => generatePassword(16),
                'username' => $userEmail,
                'ip_address' => $this->request->getIPAddress(),
                'active' => 1,
                'activated_at' => date('Y-m-d H:i:s')
            ]);

            if (!$authModel->save($auth)) {
                //in case the profile creation fails, delete the user created above
                $users->delete($newUserId);
                // redirect back to register page
                return redirect()->back()->withInput()->with('errors', $authModel->errors());
            }

            // login user by id
            $this->auth->loginByID($newUserId);

            $redirectURL = session('redirect_url') ?? site_url('/');
            unset($_SESSION['redirect_url']);
            return redirect()->to($redirectURL)->withCookies()->with('message', lang('Auth.loginSuccess'));
        }

        return redirect()->to("/")->withCookies()->with('error', lang("Error.error_222"));
    }
}
