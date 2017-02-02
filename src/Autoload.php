<?php

namespace App;

class Autoload {

    /**
     * Holds all namespace prefixes with paths for autoloading
     * @var array
     */
    private $namespacePrefixes = [];

    /**
     * @return Autoload
     */
    public static function create()
    {
        return new static();
    }

    /**
     * Registers namespace
     * @param $namespace string namespace prefix
     * @param $prefix string path for loading files
     * @return Autoload
     */
    public function registerNamespace($namespace, $prefix)
    {
        $this->namespacePrefixes[$namespace] = $prefix;

        return $this;
    }

    public function autoload($className)
    {
        $className = explode('\\', $className);
        if (count($className) <= 1) {
            // Use default autoloader, if it exists.
            return;
        }

        $prefix = array_shift($className);
        if (!isset($this->namespacePrefixes[$prefix])) {
            // We dont have this prefix in configuration. Skip loading
            return;
        }

        $path = $this->namespacePrefixes[$prefix] . implode(DS, $className) . PHP_EXT;
        if (!file_exists($path) || !is_readable($path)) {
            // We dont have this file. skip
            return;
        }

        include_once $path;
    }

    public function register()
    {
        spl_autoload_register([$this, 'autoload']);
    }
}