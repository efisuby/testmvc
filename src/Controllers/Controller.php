<?php
namespace App\Controllers;


use App\Core\Abstracts\Creatable;
use App\Core\HandleResult;
use App\Core\HttpRequest;
use Core\Exceptions\HttpException;

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
        return null;
    }

    /**
     * @inheritDoc
     */
    public function postHandleRequest(HttpRequest $request, HandleResult $result)
    {
        return null;
    }


    /**
     * @return string
     */
    protected function getDefaultAction()
    {
        return 'index';
    }
}