<?php

namespace Modules\Auth\Controllers;

class LogoutApiController extends BaseAuthController
{
    /**
     * Log the user out.
     */
    public function logout()
    {
        if ($this->auth->check()) {
            $this->auth->logout();
        }

        return redirect()->to(site_url('/'))->withInput()->with('success', "Logged out successfully");
    }
}
