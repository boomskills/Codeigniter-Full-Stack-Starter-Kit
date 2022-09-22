<?php

namespace Modules\Auth\Controllers;

use CodeIgniter\Events\Events;
use Modules\Auth\Models\AuthModel;

class ActivationAuthController extends BaseAuthController
{
    /**
     * Activate Account.
     *
     * @return mixed
     */
    public function activateAccount()
    {
        $authModel = new AuthModel();

        // First things first - log the activation attempt.
        $authModel->logActivationAttempt(
            $this->request->getGet('token'),
            $this->request->getIPAddress(),
            (string) $this->request->getUserAgent()
        );

        $throttler = service('throttler');

        if (false === $throttler->check(md5($this->request->getIPAddress()), 2, MINUTE)) {
            return service('response')->setStatusCode(429)->setBody(lang('Auth.tooManyRequests', [$throttler->getTokentime()]));
        }

        $auth = $authModel->where('activate_hash', $this->request->getGet('token'))->where('active', 0)->first();

        if (is_null($auth)) {
            return redirect()->route('login')->with('error', lang('Auth.activationNoAccount'));
        }

        $auth->activate();

        $authModel->save($auth);

        // trigger activate event
        Events::trigger('activate', ['auth' => $auth]);

        return redirect()->route('login')->with('message', lang('Auth.activatedSuccess'));
    }

    /**
     * Resend activation account.
     *
     * @return mixed
     */
    public function resendActivateAccount()
    {
        if (null === $this->config->requireActivation) {
            return redirect()->route('login');
        }

        $throttler = service('throttler');

        if (false === $throttler->check(md5($this->request->getIPAddress()), 2, MINUTE)) {
            return service('response')->setStatusCode(429)->setBody(lang('Auth.tooManyRequests', [$throttler->getTokentime()]));
        }

        $username = urldecode($this->request->getGet('username'));

        // get user from email
        $authModel = new AuthModel();

        $auth = $authModel->where('username', $username)->where('active', 0)->first();

        if (is_null($auth)) {
            return redirect()->route('login')->with('error', lang('Auth.activationNoAccount'));
        }

        // get user from authentication
        $user = user($auth->user_id);

        $activator = service('activator');
        $sent = $activator->send($user, $auth);

        if (!$sent) {
            return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
        }
        // trigger activate event
        Events::trigger('resend-activate', ['auth' => $auth]);

        // Success!
        return redirect()->route('login')->with('message', lang('Auth.activationSendSuccess'));
    }
}
