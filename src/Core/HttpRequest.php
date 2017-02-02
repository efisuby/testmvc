<?php
namespace App\Core;


use App\Core\Abstracts\Creatable;

class HttpRequest extends Creatable
{
    /* notation of variables extends global ones */
    protected $_get;
    protected $_post;
    protected $_files;
    protected $_cookies;
    protected $_server;

    protected $rawPost;

    public static function createFromGlobals()
    {
        return
            static::create()
                ->setCookies($_COOKIE)
                ->setFiles($_FILES)
                ->setGet($_GET)
                ->setPost($_POST)
                ->setServer($_SERVER);
    }

    public function getPostVar($var, $default = null)
    {
        if (isset($this->_post[$var])) {
            return $this->_post[$var];
        } else {
            return $default;
        }
    }

    public function getGetVar($var, $default = null)
    {
        if (isset($this->_get[$var])) {
            return $this->_get[$var];
        } else {
            return $default;
        }
    }

    public function getRequestVar($var, $default = null)
    {
        return
            $this->getGetVar(
                $var,
                $this->getPostVar($var, $default)
            );
    }

    public function getRawBody()
    {
        if ($this->rawPost == null) {
            $this->rawPost = file_get_contents('php://input');
        }

        return null;
    }

    /**
     * @return array
     */
    public function getGet()
    {
        return $this->_get;
    }

    /**
     * @param array $get
     * @return HttpRequest
     */
    public function setGet($get)
    {
        $this->_get = $get;
        return $this;
    }

    /**
     * @return array
     */
    public function getPost()
    {
        return $this->_post;
    }

    /**
     * @param array $post
     * @return HttpRequest
     */
    public function setPost($post)
    {
        $this->_post = $post;
        return $this;
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->_files;
    }

    /**
     * @param array $files
     * @return HttpRequest
     */
    public function setFiles($files)
    {
        $this->_files = $files;
        return $this;
    }

    /**
     * @return array
     */
    public function getCookies()
    {
        return $this->_cookies;
    }

    /**
     * @param array $cookies
     * @return HttpRequest
     */
    public function setCookies($cookies)
    {
        $this->_cookies = $cookies;
        return $this;
    }

    /**
     * @return array
     */
    public function getServer()
    {
        return $this->_server;
    }

    /**
     * @param array $server
     * @return HttpRequest
     */
    public function setServer($server)
    {
        $this->_server = $server;
        return $this;
    }


}