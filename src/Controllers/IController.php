<?php
/**
 * Created by PhpStorm.
 * User: spell
 * Date: 02.02.17
 * Time: 23:41
 */

namespace App\Controllers;


use App\Core\Abstracts\ICreatable;
use App\Core\HandleResult;
use App\Core\HttpRequest;
use Core\Exceptions\HttpException;

/**
 * Interface IController
 * Main controller interface
 * @package App\Controllers
 */
interface IController extends ICreatable
{
    /**
     * Main controller function. It must process request within controller and return HandleResult
     * If HttpException will be thrown - handle request will be terminated and user will get an error
     *
     * @param HttpRequest $request
     * @return HandleResult
     * @throws HttpException
     */
    public function handleRequest(HttpRequest $request);

    /**
     * This function runs before main handle request starts.
     *
     * If handle result will be returned - handleRequest will not run and application cycle will process it
     * If HttpException will be thrown - handle request will be terminated and user will get an error

     * @param HttpRequest $request
     * @throws HttpException
     * @return null|HandleResult
     */
    public function preHandleRequest(HttpRequest $request);

    /**
     * This function used for request postprocessing
     * If HttpException will be thrown - handle request will be terminated and user will get an error
     *
     * @param HttpRequest $request
     * @param HandleResult $result
     * @throws HttpException
     * @return void
     */
    public function postHandleRequest(HttpRequest $request, HandleResult $result);
}