<?php
/**
 * Created by PhpStorm.
 * User: spell
 * Date: 02.02.17
 * Time: 23:46
 */

namespace App\Core\Exceptions;


use App\Core\HandleResult;

class HttpException extends \Exception
{
    /**
     * @return HandleResult
     */
    public function getErrorResult()
    {
        return
            HandleResult::create()
                ->setView(ERROR_TEMPLATE)
                ->setVar('exception', $this);
    }
}