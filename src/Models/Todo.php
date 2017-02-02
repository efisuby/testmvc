<?php

namespace App\Models;

class Todo extends Model implements IModel
{
    protected $id;
    protected $email;
    protected $name;
    protected $text;
    protected $image;

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
            'image' => self::prepareSchemaItem('image'),
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
        $this->image = $image;
    }


}