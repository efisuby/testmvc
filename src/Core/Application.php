<?php
namespace App\Core;
use App\Controllers\IController;
use App\Core\Abstracts\Creatable;
use App\Core\Exceptions\HttpException;

/**
 * Main application class. It will handle all site loading logic
 */
class Application extends Creatable
{

    protected $controllerName;

    public function handleRequest(HttpRequest $request)
    {
        try {
            $controllerClass = $this->getControllerClass($request);
            $result = $controllerClass->preHandleRequest($request);

            if ($result == null) {
                $result = $controllerClass->handleRequest($request);
            }

            if ($result == null) {
                $result = HandleResult::create();
            }

            $controllerClass->postHandleRequest($request, $result);
        } catch (HttpException $e) {
            $result = $e->getErrorResult();
        }

        $this->processResult($request, $result);
    }

    protected function processResult(HttpRequest $request, HandleResult $result)
    {
        Template::addTemplatePath(TEMPLATE_PATH . $this->getControllerName($request) . DS);
        Template::addTemplatePath(TEMPLATE_PATH . 'common' . DS);

        Template::create()->handleResult($result);
    }

    /**
     * @param HttpRequest $request
     * @return IController
     * @throws HttpException
     */
    protected function getControllerClass(HttpRequest $request)
    {
        $controller = $this->getControllerName($request);

        /** @var IController $className */
        $className = CONTROLLER_NS_PREFIX . ucfirst($controller);
        if (class_exists($className) && class_implements($className, IController::class)) {
            return $className::create();
        } else {
            throw new HttpException("Bad controller");
        }
    }

    protected function getControllerName(HttpRequest $request)
    {
        if ($this->controllerName == null) {
            $this->controllerName = $request->getRequestVar('area', MAIN_CONTROLLER);
        }

        return $this->controllerName;
    }
}