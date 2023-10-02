<?php

namespace models;

use core\Application;
use core\UserModel;

class Teacher extends User
{
    public int $id_role = 2;

    public function rules(): array
    {
        return [
            "email" => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, "class" => self::class]],
            // "password" => [self::RULE_REQUIRED, [self::RULE_MIN, "min" => 6], [self::RULE_MAX, "max" => 24]],
            "firstname" => [self::RULE_REQUIRED, [self::RULE_MIN, "min" => 3], [self::RULE_MAX, "max" => 100]],
            "lastname" => [self::RULE_REQUIRED, [self::RULE_MIN, "min" => 3], [self::RULE_MAX, "max" => 100]],
            "address" => [self::RULE_REQUIRED],
            "bday" => [self::RULE_REQUIRED],
        ];
    }

    public function getAllTeachers()
    {
        return parent::all();
    }

    public static function getAsignedClass($id)
    {
        return parent::findInOtherTableByID("classes", $id);
    }
    public function delete($id)
    {
        return parent::delete($id);
    }

    public function getAllClasses() 
    {
        return parent::allOtherTable("classes");
    }

    public function saveAsignedClass($classID, $teacherID, $tableName) 
    {
        $statement = self::prepare("UPDATE $tableName SET id_teacher = $teacherID  WHERE id = $classID");
        $statement->execute();
        return true;
    }
}