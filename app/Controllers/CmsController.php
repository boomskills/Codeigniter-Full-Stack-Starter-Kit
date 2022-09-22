<?php

namespace App\Controllers;

class CmsController extends ClientBaseController
{
    public function index()
    {
        helper('auth');
        if (logged_in()) {
            return redirect()->to('admin/dashboard');
        }

        return redirect()->to(base_url('/'));
    }
}
