<?php

namespace App\Models;

use App\Core\HttpRequest;

class Todo extends Model implements IModel
{
    protected $id;
    protected $email;
    protected $name;
    protected $text;
    protected $image;
    protected $finished = false;

    protected static $allowedMimes = [
        'image/jpeg' => '.jpg',
        'image/gif' => '.gif',
        'image/png' => '.png',
    ];

    public static function getTable()
    {
        return 'todos';
    }

    /* Need to check this function if fields are changed */
    public static function getSchema()
    {
        return [
            'id' => self::prepareSchemaItem('id', true),
            'email' => self::prepareSchemaItem('email'),
            'name' =>  self::prepareSchemaItem('name'),
            'text' =>  self::prepareSchemaItem('text'),
            'image' => self::prepareSchemaItem('image', false, true),
            'finished' => self::prepareSchemaItem('finished'),
        ];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return bool
     */
    public function isFinished()
    {
        return $this->finished == true;
    }

    /**
     * @return bool
     */
    public function getFinished()
    {
        return (int)$this->finished;
    }

    /**
     * @param bool $finished
     * @return Todo
     */
    public function setFinished($finished)
    {
        $this->finished = (int)$finished;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        if ($tmpImage = $this->processImage()) {
            $this->image = $tmpImage;
        } elseif ($image) {
            $this->image = $image;
        }
    }

    protected function processImage()
    {
        $request = HttpRequest::createFromGlobals();
        $filesArray = $request->getFiles();
        if (!isset($filesArray['image'])) {
            return null;
        }

        $imageArray = $filesArray['image'];

        if (
            !isset(static::$allowedMimes[$imageArray['type']])
            || static::$allowedMimes[$imageArray['type']] == null
        ) {
            return null;
        }

        $fileName = md5(time() . $imageArray['name']) . static::$allowedMimes[$imageArray['type']];
        $uploadDir = UPLOAD_PATH . substr($fileName, 0, 1) . DS;
        $image = UPLOAD_WEB_PATH . substr($fileName, 0, 1) . '/' . $fileName;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir);
        }

        move_uploaded_file($imageArray['tmp_name'], $uploadDir . $fileName);
        $imagick = new \Imagick($uploadDir . $fileName);

        if ($imagick->scaleImage(320, 240, true)) {
            file_put_contents($uploadDir . $fileName, $imagick->getImageBlob());
        }

        return $image;
    }

}