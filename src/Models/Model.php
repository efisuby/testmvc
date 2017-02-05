<?php

namespace App\Models;

use App\Core\Abstracts\Creatable;
use App\Core\DB\DBPool;
use App\Core\Exceptions\HttpException;

abstract class Model extends Creatable implements IModel
{
    const ORDER_ASC = 'ASC';
    const ORDER_DESC = 'DESC';

    protected static $oppositeOrderList = [
        self::ORDER_ASC => self::ORDER_DESC,
        self::ORDER_DESC => self::ORDER_ASC
    ];

    protected static $defaultOrder = self::ORDER_ASC;

    /**
     * @param $id
     * @return static
     */
    public static function get($id)
    {
        return self::getByCondition(['id' => $id]);
    }

    /**
     * @param $condition
     * @return static
     */
    public static function getByCondition($condition)
    {
        $list = self::getListByCondition($condition);

        return $list[0];
    }

    /**
     * @param array $conditions
     * @param array $order
     * @return static[]
     */
    public static function getListByCondition($conditions = [], $order = [])
    {
        $db = DBPool::getInstance()->get();
        $condition = " true ";
        foreach ($conditions as $key => $value) {
            $condition .= ' and ' . $key . ' = :' . $key;
        }
        $stmt = 'select * from ' . static::getTable()  . ' WHERE '. $condition;

        if (!empty($order)) {
            $stmt .= ' ORDER BY ';
            $firstOrder = true;
            foreach ($order as $field => $direction) {
                if ($firstOrder) {
                    $firstOrder = false;
                } else {
                    $stmt .= ', ';
                }
                $direction = isset(static::$oppositeOrderList[$direction]) ? $direction : null;
                $stmt .= $field . ' ' . $direction;
            }
        }

        $query = $db->prepare($stmt);

        $query->execute($conditions);
        $result = [];
        while ($arr = $query->fetch()) {
            $result[] = self::array2Object($arr);
        }

        return $result;
    }

    public static function parseOrder($order)
    {
        return (isset(static::$oppositeOrderList[$order]))
            ? $order
            : static::$defaultOrder;
    }

    public static function parseField($field)
    {
        static $schema = null;
        if ($schema == null) {
            $schema = static::getSchema();
        }


        if (isset($schema[$field])) {
            return $field;
        } else {
            throw new HttpException("Bad sort field");
        }
    }

    public static function getOppositeOrderDirection($order)
    {
        if (isset(static::$oppositeOrderList[$order])) {
            return static::$oppositeOrderList[$order];
        } else {
            return static::$defaultOrder;
        }
    }
    public static function array2Object(array $array = [], $object = null)
    {
        $schema = static::getSchema();
        $object = $object ?: static::create();

        foreach ($schema as $key => $item) {
            if (isset($array[$key]) || $item['mustToRun']) {
                $object->{$item['setter']}(isset($array[$key]) ? $array[$key] : null);
            }
        }

        return $object;
    }

    protected static function prepareSchemaItem($colName, $primary = false, $must = false)
    {
        return [
            'setter' => 'set' . ucfirst($colName),
            'getter' => 'get' . ucfirst($colName),
            'primary' => $primary,
            'mustToRun' => $must
        ];
    }

    public function save()
    {
        $schema = static::getSchema();
        $fields = array_keys($schema);
        $where = [];
        $setData = [];
        $isInsert = false;
        foreach ($fields as $field) {
            $getter = $schema[$field]['getter'];
            $isPrimary = $schema[$field]['primary'];
            if ($this->{$getter}() == null && $isPrimary) {
                $isInsert = true;
            } elseif ($isPrimary) {
                $where[$field] = $this->{$getter}();
            }

            $setData[$field] = $this->{$getter}();
        }

        if ($isInsert) {
            return $this->insert($setData);
        } else {
            return $this->update($setData, $where);
        }
    }

    protected function update(array $setValues, array $where)
    {
        $stmt = 'UPDATE ' . static::getTable() . ' SET ';
        $first = true;
        foreach ($setValues as $key => $dummy) {
            if (!$first) {$stmt.=', ';}
            $first = false;
            $stmt .= $key . ' = :' . $key;
        }

        var_dump($setValues);
        $stmt .= ' WHERE TRUE';
        foreach ($where as $key => $value)
        {
            $stmt .= ' AND ' . $key . ' = :w'. $key;
            $setValues['w' . $key] = $value;
        }

        $db = DBPool::getInstance()->get();
        $db->beginTransaction();
        $query = $db->prepare($stmt);

        if (!$query->execute($setValues)) {
            $db->rollBack();
            throw new \RuntimeException(var_export($query->errorInfo(), true));
        }
        $db->commit();

        return true;
    }

    protected function insert(array $values)
    {
        $stmt = 'INSERT INTO ' . static::getTable();
        $stmt .= ' (' . implode(', ', array_keys($values)) . ')';
        $stmt .= ' VALUES (:' . implode(', :', array_keys($values)) . ')';

        $db = DBPool::getInstance()->get();
        $db->beginTransaction();
        $query = $db->prepare($stmt);
        if (!$query->execute($values)) {
            throw new \RuntimeException(var_export($query->errorInfo(), true));
        }
        $this->setId($db->lastInsertId());

        $db->commit();

        return true;
    }
}