<?php

namespace App\Controllers;

use App\Core\Exceptions\HttpException;
use App\Core\Exceptions\RedirectException;
use App\Core\HandleResult;
use App\Core\HttpRequest;

class Todo extends Controller implements IController
{
    public function indexAction()
    {
        throw new RedirectException('/');
    }

    public function addAction()
    {
        return HandleResult::create()->setView("addForm");
    }

    public function createAction(HttpRequest $request)
    {
        \App\Models\Todo::array2Object($request->getPost())->save();
        throw new RedirectException('/');
    }

    public function finishAction(HttpRequest $request)
    {
        if ($id = $request->getRequestVar('id')) {
            \App\Models\Todo::get($id)->setFinished(true)->save();
        }

        throw new RedirectException('/');
    }

    public function updateAction(HttpRequest $request)
    {
        if ($id = $request->getRequestVar('id')) {
            $object = \App\Models\Todo::get($id);

            \App\Models\Todo::array2Object($request->getPost(), $object)->save();
        }
        throw new RedirectException('/');
    }

    public function editAction(HttpRequest $request)
    {
        if ($id = $request->getRequestVar('id')) {
            return
                HandleResult::create()
                    ->setView('addForm')
                    ->setVar('object', \App\Models\Todo::get($id));
        }

        throw new RedirectException('/');
    }

    protected function getForbiddenActions()
    {
        return [
            'edit',
            'finish',
            'update'
        ];
    }


}