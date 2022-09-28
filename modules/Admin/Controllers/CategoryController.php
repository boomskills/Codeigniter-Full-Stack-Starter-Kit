<?php

namespace Modules\Admin\Controllers;

use App\Models\CategoryModel;

class CategoryController extends BaseAdminController
{
    protected $categoryModel;

    public function __construct()
    {
        parent::__construct();
        $this->categoryModel = new CategoryModel();
    }

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return mixed
     */
    public function index()
    {
        $this->data['categories'] = $this->categoryModel->findAll();
        $this->data['panel_title'] = 'Categories';

        return $this->_render($this->admin->views['category']['index'], $this->data);
    }


    /**
     * Return a new resource object, with default properties.
     *
     * @return mixed
     */
    public function new()
    {
        $this->data['panel_title'] = 'Create Category';
        return $this->_render($this->admin->views['category']['new'], $this->data);
    }


    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return mixed
     */
    public function create()
    {
        if (!$this->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $payload = [
            'slug' => slug($this->request->getVar('title')),
            'title' => $this->request->getVar('title'),
            'description' => $this->request->getVar('description'),
        ];

        $createOne = $this->factory->createOne($this->categoryModel, $payload);

        if ($createOne['success']) {
            return redirect()->back()->withInput()->with('success', $createOne['message']);
        }

        return redirect()->back()->withInput()->with('error', $createOne['message']);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        $model = $this->categoryModel->find($id);

        if (!$model) {
            return $this->template->__admin_error(lang('Error.error_212'));
        }

        $this->data['panel_title'] = $model->title;
        $this->data['category'] = $model;

        return $this->_render($this->admin->views['category']['edit'], $this->data);
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
        $model = $this->categoryModel->find($id);

        if (!$model) {
            return $this->template->__admin_error(lang('Error.error_212'));
        }

        $payload = [
            'slug' => slug($this->request->getVar('title')),
            'title' => $this->request->getVar('title'),
            'description' => $this->request->getVar('description'),
        ];

        $updateOne = $this->factory->updateOne($this->categoryModel, $payload, $id);

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
        $model = $this->categoryModel->find($id);

        if (!$model) {
            return $this->template->__admin_error(lang('Error.error_212'));
        }

        $deleteOne = $this->factory->deleteOne($this->categoryModel, $id);

        if ($deleteOne['success']) {
            return redirect()->back()->withInput()->with('success', $deleteOne['message']);
        }

        return redirect()->back()->withInput()->with('error', $deleteOne['message']);
    }
}
