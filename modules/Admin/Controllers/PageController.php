<?php

namespace Modules\Admin\Controllers;

use App\Models\PageModel;

class PageController extends BaseAdminController
{
    protected $pageModel;

    public function __construct()
    {
        parent::__construct();
        $this->pageModel = new PageModel();
    }

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return mixed
     */
    public function index()
    {
        $this->data['panel_title'] = 'Pages';
        $this->data['pages'] = $this->pageModel->findAll();

        return $this->_render($this->admin->views['page']['index'], $this->data);
    }

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return mixed
     */
    public function new()
    {
        $this->data['panel_title'] = 'Create Page';

        return $this->_render($this->admin->views['page']['new'], $this->data);
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return mixed
     */
    public function create()
    {
        if (!$this->validate([
            'page_title' => 'required|string',
            'page_content' => 'required|string',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $title = $this->request->getVar('page_title');

        $createOne = $this->factory->createOne($this->pageModel, [
            'slug' => slug($title),
            'title' => $title,
            'content' => $this->request->getVar('page_content'),
        ]);

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
        $model = $this->pageModel->find($id);

        if (!$model) {
            return $this->template->__admin_error(lang('Error.siteSliderNotFound'), $this->data);
        }

        $this->data['page'] = $model;
        $this->data['panel_title'] = $model->title;

        return $this->_render($this->admin->views['page']['edit'], $this->data);
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
        $model = $this->pageModel->find($id);

        if (!$model) {
            return redirect()->back()->withInput()->with('error', lang('Error.staticPageNotFound'));
        }

        $title = $this->request->getVar('page_title');

        $updateOne = $this->factory->updateOne($this->pageModel, [
            'slug' => slug($title),
            'title' => $title,
            'content' => $this->request->getVar('page_content'),
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
        $model = $this->pageModel->find($id);

        if (!$model) {
            return redirect()->back()->withInput()->with('error', lang('Error.pageNotFound'));
        }

        $deleteOne = $this->factory->deleteOne($this->pageModel, $id);

        if ($deleteOne['success']) {
            return redirect()->back()->withInput()->with('success', $deleteOne['message']);
        }

        return redirect()->back()->withInput()->with('error', $deleteOne['message']);
    }
}
