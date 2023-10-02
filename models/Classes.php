<?php

namespace models;

use core\DbModel;

class Classes extends User
{

    public function tableName(): string
    {
        return "classes";
    }

    public function rules(): array
    {
        return [
            "name" => [self::RULE_REQUIRED],
        ];
    }

    public function rulesUpdate(): array
    {
        return [
            // "name" => [self::RULE_REQUIRED],
        ];
    }

    public function attributes(): array
    {
        return ["name"];
    }

    public function getAllClasses()
    {
        return parent::all();
    }

    public static function getTeacherName($classId)
    {
        $teacher = parent::findInOtherTableByColumn('users', 'id_class', $classId);
        if ($teacher) {
            return  $teacher->firstname . " " .  $teacher->lastname;
        }
        return false;
    }

    public static function getCount($id, $columnToCompare, $tableName)
    {

        $count = parent::countCompareById($id, $columnToCompare, $tableName);
        return $count->{'COUNT(users.id_class)'};
    }

    public function getAllTeachers()
    {
        $teachers = [];
        $users = parent::allOtherTable("users");

        foreach ($users as $user) {
            if ($user['id_role'] === 2) {
                echo "verdad";
                $teachers[] = $user;
            }
            echo "falso";
            continue;
        }
  
        return $teachers;
    }

    public function assignClass($teacherId, $classId)
    {
        parent::updatedColumn($teacherId, $classId);
        return true;
    }
}
