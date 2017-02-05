<?php

namespace App\Core\Exceptions;

use App\Core\HandleResult;

class RedirectException extends HttpException
{
    /**
     * @inheritDoc
     */
    public function getErrorResult()
    {
        return
            HandleResult::create()
                ->setVar("url", $this->getMessage())
                ->setMainView('redirect');
    }

}