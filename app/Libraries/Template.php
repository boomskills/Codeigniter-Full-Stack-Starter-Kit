<?php

namespace App\Libraries;

class Template
{
    protected $data = [];
    protected $admin_error_view = 'Modules\Admin\Views\error\error';
    protected $client_error_view = 'error/error';
    protected $modal_error = 'error/modal_error';

    public function __client_error($message = null)
    {
        echo view($this->client_error_view, ['message' => $message]);
    }

    public function __admin_error($message = null, $data = [])
    {
        return view($this->admin_error_view, array_merge($data, ['message' => $message]));
    }

    public function modalError($msg, $die = 0)
    {
        echo view($this->modal_error, ['err_msg' => $msg]);
        if ($die) {
            exit();
        }
    }
}
