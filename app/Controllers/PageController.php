<?php

namespace App\Controllers;

use App\Models\PageModel;

class PageController extends ClientBaseController
{
    protected $pageModel;

    public function __construct()
    {
        parent::__construct();
        $this->pageModel = new PageModel();
    }

    /**
     * Displays a static page.
     *
     * @param null|mixed $pageSlug
     */
    public function showPage($pageSlug = null)
    {
        $page = $this->pageModel->where('slug', $pageSlug)->first();

        if (!$page) {
            return $this->template->__client_error(lang('Error.error_216'));
        }

        $this->data['content'] = $page;
        $this->data['page'] = 'pages/show';
        $this->render_layout($this->data);
    }



    /**
     * Displays a contact page.
     */
    public function contact_page()
    {
        $page = $this->pageModel->where('slug', 'contact-us')->first();

        if (!$page) {
            return $this->template->__client_error(lang('Error.error_216'));
        }

        $this->data['content'] = $page;
        $this->data['head_title'] = $page->title;
        $this->data['page'] = 'pages/contact-us';
        $this->render_layout($this->data);
    }

    /**
     * Handles contact form submission
     */
    public function handleContactSubmit()
    {
        $from = trim($this->request->getVar('email'));
        $name = trim($this->request->getVar('name'));
        $message = trim($this->request->getVar('message'));

        $email = \Config\Services::email();

        $email->setFrom($from, $name);
        $email->setTo($this->settings->info->site_email);
        $email->setSubject('New message from ' . $name);
        $email->setMessage($message);

        //Send mail
        if ($email->send()) {
            return redirect()->back()->withInput()->with('txtSuccess', 'Email sent successfully.');
        }

        return redirect()->back()->withInput()->with('txtError', 'Error in sending Email.');
    }
}
