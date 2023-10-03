<?php

namespace core;

abstract class DbModel extends Model
{
    abstract public function tableName(): string;

    abstract public function attributes(): array;

    abstract public static function primaryKey(): string;

    public  function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $checkedAttrs = [];
        foreach ($attributes as $attr) {
            if ($this->{$attr}) {
                $checkedAttrs[] = $attr;
            }
            continue;
        }
        $params = array_map(fn ($attr) => ":$attr", $checkedAttrs);
        $statement = self::prepare("INSERT INTO $tableName (" . implode(',', $checkedAttrs) . ") VALUES (" . implode(',', $params) . ")");
        foreach ($checkedAttrs as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();
        $statement = self::prepare("SELECT * FROM $tableName where id = (SELECT LAST_INSERT_ID())");
        $statement->execute();
        return $statement->fetchObject();
    }

    public  function update($id)
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $attributesToUpdate = [];
        foreach ($attributes as $attribute) {
            if ($this->{$attribute}) {
                $attributesToUpdate[] = $attribute;
            }
        }
        $params = [];
        foreach ($attributesToUpdate as $attr) {
            $params[] = "$attr" . "=" . ":$attr";
        }
        $statement = self::prepare("UPDATE $tableName SET " . implode(',', $params) . " WHERE id = $id");
        foreach ($attributesToUpdate as $attribute) {

            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        return $statement->execute();  
    }

    public  function updatedSpe($id, $attributes)
    {
        $tableName = $this->tableName();
        $attributesToUpdate = [];
        foreach ($attributes as $attribute) {
            if ($this->{$attribute}) {
                $attributesToUpdate[] = $attribute;
            }
        }
        $params = [];
        foreach ($attributesToUpdate as $attr) {
            $params[] = "$attr" . "=" . ":$attr";
        }
        $statement = self::prepare("UPDATE $tableName SET " . implode(',', $params) . " WHERE id = $id");
        foreach ($attributesToUpdate as $attribute) {

            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        return $statement->execute();  
    }

    public function findOne($where)
    {

        $tableName = $this->tableName();
        $attributes = array_keys($where);
        $sql = implode("AND", array_map(fn ($attr) => "$attr = :$attr", $attributes));

        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    public function findAll($where)
    {

        $tableName = $this->tableName();
        $attributes = array_keys($where);
        $sql = implode("AND", array_map(fn ($attr) => "$attr = :$attr", $attributes));

        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetchAll();
    }

    public static function findAllinOtherTable($tableName, $where)
    {
        $attributes = array_keys($where);
        $sql = implode("AND", array_map(fn ($attr) => "$attr = :$attr", $attributes));

        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetchAll();
    }

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    public function all()
    {
        $tableName = $this->tableName();
        $statement = self::prepare("SELECT * FROM $tableName");
        $statement->execute();
        return $statement->fetchAll();
    }

    public static function get($id, $tableName)
    {
        $statement = self::prepare("SELECT * FROM $tableName WHERE id = $id");
        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    public function allOtherTable($tableName)
    {
        $statement = self::prepare("SELECT * FROM $tableName");
        $statement->execute();
        return $statement->fetchAll();
    }

    public static function findInOtherTableByColumn($tableName, $column, $value)
    {
        $statement = self::prepare("SELECT * FROM $tableName WHERE $column = $value");
        $statement->execute();
        return $statement->fetchObject();
    }

    public static function findInOtherTableByColumnWithCondition($tableName, $column, $value, $colCondition, $conditionValue)
    {
        $statement = self::prepare("SELECT * FROM $tableName WHERE $column = $value AND $colCondition = $conditionValue");
        $statement->execute();
        return $statement->fetchObject();
    }

    public static function countCompareById($id, $columnToCompare, $tableName)
    {
        $statement = self::prepare("SELECT COUNT($tableName.$columnToCompare) FROM $tableName WHERE $columnToCompare = $id");
        $statement->execute();
        return $statement->fetchObject();
    }

    public function delete($id)
    {
        $tableName = $this->tableName();
        $statement = self::prepare("DELETE FROM $tableName WHERE id = $id");
        return $statement->execute();
    }

    public function assignTeacher($teacherId, $classId) {
        $tableName = $this->tableName();
        $statement = self::prepare("UPDATE $tableName SET id_teacher = $teacherId WHERE id = $classId");
        return $statement->execute();
    }

}
