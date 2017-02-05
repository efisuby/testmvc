<?php

namespace App\Core\Abstracts;

trait Singleton
{
    /**
     * Instance
     *
     * @var static
     */
    protected static $instance;

    protected function __construct()
    {

    }

    /**
     * Get instance
     *
     * @return static
     */
    public final static function getInstance() {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}
