<?php

namespace App\Core;


use App\Core\Abstracts\Creatable;

class Template extends Creatable
{
    protected static $templatePath = [];

    public static function addTemplatePath($path)
    {
        self::$templatePath[] = $path;
    }

    public function handleResult(HandleResult $result)
    {
        $this->render($result->getMainView(), ['view' => $result->getView()] + $result->getVars());
    }

    public function render($template, $vars = [])
    {
        foreach ($vars as $var => $value) {
            $$var = $value;
        }

        include $this->getTemplate($template);
    }

    protected function getTemplate($template, $error = false)
    {
        foreach (self::$templatePath as $path) {
            if (file_exists($path . $template . TPL_EXT)) {
                return $path . $template . TPL_EXT;
            }
        }

        if ($error) {
            throw new \Exception("Failed to load ERROR template");
        }

        return $this->getTemplate(ERROR_TEMPLATE, true);
    }
}