<?php

namespace App\Models;

use App\Core\Abstracts\Creatable;
use App\Core\DB\DBPool;

abstract class Model extends Creatable implements IModel
{
    public static function get($id)
    {
        $list = self::getListByCondition(['id' => $id]);

        return $list[0];
    }

    public static function getListByCondition($conditions = [])
    {
        $db = DBPool::getInstance()->get();
        $condition = " true ";
        foreach ($conditions as $key => $value) {
            $condition .= ' and ' . $key . ' = :' . $key;
        }
        $query = $db->prepare('select * from ' . static::getTable()  . ' WHERE '. $condition);

        $query->execute($conditions);
        $result = [];
        while ($arr = $query->fetch()) {
            $result[] = self::array2Object($arr);
        }

        return $result;
    }

    public static function array2Object(array $array = [])
    {
        $schema = static::getSchema();
        $object = static::create();

        foreach ($schema as $key => $item) {
            $object->{$item['setter']}($array[$key]);
        }

        return $object;
    }

    protected static function prepareSchemaItem($colName, $primary = false)
    {
        return [
            'setter' => 'set' . ucfirst($colName),
            'getter' => 'get' . ucfirst($colName),
            'primary' => $primary
        ];
    }
}