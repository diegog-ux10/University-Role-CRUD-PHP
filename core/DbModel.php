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
        return true;
    }

    public  function updated($id)
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
        $statement->execute();
        return true;
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

    public function allOtherTable($tableName)
    {
        $statement = self::prepare("SELECT * FROM $tableName");
        $statement->execute();
        return $statement->fetchAll();
    }

    public static function findInOtherTableByID($tableName, $id)
    {
        $statement = self::prepare("SELECT * FROM $tableName WHERE id = $id");
        $statement->execute();
        return $statement->fetchObject();
    }

    public static function findInOtherTableByColumn($tableName, $column, $value)
    {
        $statement = self::prepare("SELECT * FROM $tableName WHERE $column = $value AND id_role = 2");
        $statement->execute();
        return $statement->fetchObject();
    }

    public static function countCompareById($id, $columnToCompare, $tableName)
    {
        $statement = self::prepare("SELECT COUNT($tableName.$columnToCompare) FROM $tableName WHERE $columnToCompare = $id AND id_role = 3");
        $statement->execute();
        return $statement->fetchObject();
    }

    public function delete($id)
    {
        $tableName = $this->tableName();
        $statement = self::prepare("DELETE FROM $tableName WHERE id = $id");

        $statement->execute();
        return true;
    }

    public function updatedColumn($teacherId, $classId)
    {
        $statement = self::prepare("UPDATE teachers SET id_class = $classId WHERE id = $teacherId");
    }
}
