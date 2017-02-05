<?php
namespace App\Models;

class User extends Model implements IModel
{
    protected $id;
    protected $login;
    protected $password;

    public static function getTable()
    {
        return 'users';
    }

    public static function getSchema()
    {
        return [
            'id' => static::prepareSchemaItem('id', true),
            'login' => static::prepareSchemaItem('login'),
            'password' => static::prepareSchemaItem('password'),
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
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setNewPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function validatePassword($password)
    {
        return password_verify($password, $this->password);
    }


}