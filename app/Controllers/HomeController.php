<?php

namespace App\Controllers;

class HomeController extends ClientBaseController
{
    public function index()
    {
        $this->data['page'] = 'home';
        $this->render_layout($this->data);
    }
}
