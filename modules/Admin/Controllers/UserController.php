<?php

namespace Modules\Admin\Controllers;

use App\Models\UserModel;

class UserController extends BaseAdminController
{
    protected $userModel;
    protected $crud;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new UserModel();
    }

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return mixed
     */
    public function index()
    {
        $this->data['panel_title'] = 'Users Management';
        $this->data['users'] = $this->userModel->orderBy('created_at', 'DESC')->findAll();
        return $this->_render($this->admin->views['user']['index'], $this->data);
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return $this->template->__admin_error(lang('Error.error_207'), $this->data);
        }

        $this->data['edit_user'] = $user;
        $this->data['panel_title'] = $user->name;

        return $this->_render($this->admin->views['user']['edit'], $this->data);
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return $this->template->__admin_error(lang('Error.error_207'), $this->data);
        }

        $updateOne = $this->factory->updateOne($this->userModel, [
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
        ], $id);

        if ($updateOne['success']) {
            return redirect()->back()->withInput()->with('success', $updateOne['message']);
        }

        return redirect()->back()->withInput()->with('error', $updateOne['message']);
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return $this->template->__admin_error(lang('Error.error_207'), $this->data);
        }

        $deleteOne = $this->factory->deleteOne($this->userModel, $id);

        if ($deleteOne['success']) {
            return redirect()->back()->withInput()->with('success', $deleteOne['message']);
        }

        return redirect()->back()->withInput()->with('error', $deleteOne['message']);
    }
}
