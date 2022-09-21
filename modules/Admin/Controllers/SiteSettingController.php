<?php

namespace Modules\Admin\Controllers;

use App\Models\SettingsModel;

class SiteSettingController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Displays a settings form.
     *
     * @param mixed $tab_position
     */
    public function index($tab_position = 1)
    {
        $this->data['panel_title'] = 'Site Settings';
        $this->data['tab_position'] = $tab_position;
        return $this->_render($this->admin->views['site_setting'], $this->data);
    }

    /**
     * Handles put|patch request to update site settings.
     *
     * @param mixed $id
     */
    public function updateSettings()
    {
        $site_title  = $this->request->getVar('site_title');
        $site_desc = $this->request->getVar("site_desc");
        $site_email = $this->request->getVar("site_email");
        $site_heading  = $this->request->getVar('site_heading');
        $meta_keywords  = $this->request->getVar('meta_keywords');
        $meta_description  = $this->request->getVar('meta_description');

        $client_layout  = $this->request->getVar('client_layout');
        $admin_layout  = $this->request->getVar('admin_layout');
        $file_types  = $this->request->getVar('file_types');

        $file_size  = $this->request->getVar('file_size');
        $default_role  = $this->request->getVar('default_role');

        $facebook_url  = $this->request->getVar('facebook_url');
        $youtube_url  = $this->request->getVar('youtube_url');
        $twitter_url  = $this->request->getVar('twitter_url');
        $instagram_url  = $this->request->getVar('instagram_url');

        $updateOne = $this->factory->updateOne((new SettingsModel()), [
            'site_title'  => $site_title,
            'site_desc' => $site_desc,
            'site_email' => $site_email,
            'site_heading'  => $site_heading,
            'meta_keywords'  => $meta_keywords,
            'meta_description'  => $meta_description,
            'client_layout'  => $client_layout,
            'admin_layout'  => $admin_layout,
            'file_types'  => $file_types,
            'file_size'  => $file_size,
            'default_role'  => $default_role,
            'facebook_url ' => $facebook_url,
            'youtube_url ' => $youtube_url,
            'twitter_url ' => $twitter_url,
            'instagram_url'  => $instagram_url,
        ], 1);

        if ($updateOne['success']) {
            return redirect()->back()->withInput()->with('success', $updateOne['message']);
        }

        return redirect()->back()->withInput()->with('error', $updateOne['message']);
    }
}
