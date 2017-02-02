<?php

namespace App\Core;


use App\Core\Abstracts\Creatable;

class HandleResult extends Creatable
{
    protected $vars = [];

    protected $view = 'content';

    protected $mainView = 'main';

    /**
     * @return array
     */
    public function getVars()
    {
        return $this->vars;
    }

    /**
     * @param array $vars
     * @return HandleResult
     */
    public function setVars($vars)
    {
        $this->vars = $vars;

        return $this;
    }

    /**
     * @param $var
     * @param $value
     * @return HandleResult
     */
    public function setVar($var, $value)
    {
        $this->vars[$var] = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @param string $view
     * @return HandleResult
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * @return string
     */
    public function getMainView()
    {
        return $this->mainView;
    }

    /**
     * @param string $mainView
     * @return HandleResult
     */
    public function setMainView($mainView)
    {
        $this->mainView = $mainView;
        return $this;
    }
}