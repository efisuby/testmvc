<?php
namespace App\Controllers;


use App\Core\Abstracts\Creatable;
use App\Core\Exceptions\HttpException;
use App\Core\Exceptions\RedirectException;
use App\Core\HandleResult;
use App\Core\HttpRequest;
use App\Core\Session;
use App\Models\User;

/**
 * Class Controller
 * Base abstract controller class
 * @package App\Controllers
 */
abstract class Controller extends Creatable implements IController
{
    /**
     * @param HttpRequest $request
     * @return mixed
     * @throws HttpException
     */
    public function handleRequest(HttpRequest $request)
    {
        $action = $request->getRequestVar('action', $this->getDefaultAction());
        $action = $action . ACTION_POSTFIX;

        if (method_exists($this, $action)) {
            return $this->$action($request);
        } else {
            throw new HttpException();
        }
    }

    /**
     * @inheritDoc
     */
    public function preHandleRequest(HttpRequest $request)
    {
        $action = $request->getRequestVar('action', $this->getDefaultAction());
        if ($this->checkForbiddenAction($action)) {
            throw new RedirectException('/');
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function postHandleRequest(HttpRequest $request, HandleResult $result)
    {
        if ($userId = Session::getInstance()->get('userId')) {
            $user = User::get($userId);
            $result->setVar('user', $user);
        }

        return null;
    }


    /**
     * @return string
     */
    protected function getDefaultAction()
    {
        return 'index';
    }

    protected function getForbiddenActions()
    {
        return [];
    }

    protected function checkForbiddenAction($action)
    {
        $actions = $this->getForbiddenActions();
        return in_array($action, $actions);
    }

}