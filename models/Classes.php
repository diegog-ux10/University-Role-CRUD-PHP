<?php

namespace models;

use core\DbModel;

class Classes extends DbModel
{
    public string $name = "";
    public int | NULL $id_teacher = NULL;

    public function tableName(): string
    {
        return "classes";
    }

    public static function primaryKey(): string
    {
        return "id";
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
        return ["name", "id_teacher"];
    }

    public function getAllClasses()
    {
        return parent::all();
    }

    public function isTeacherAssign($teacherId)
    {
        $AssignedClassToTeacher = parent::findOne(["id_teacher" => $teacherId]);
        if ($AssignedClassToTeacher) {
            return $AssignedClassToTeacher;
        } else {
            return false;
        }
    }

    public function saveClass($teacherId)
    {
        $createdClass = parent::save();
        if ($teacherId) {
            $user = User::get($teacherId, "users");
            $AssignedClassToTeacher = $this->isTeacherAssign($teacherId);
            if ($AssignedClassToTeacher) {
                parent::assignTeacher('NULL', $AssignedClassToTeacher->{'id'});
            }
            parent::assignTeacher($user->{'id'}, $createdClass->{'id'});
            return true;
        }
        return true;
    }

    public function update($id, $teacherId)
    {
        parent::updated($id);
        $AssignedClassToTeacher = $this->isTeacherAssign($teacherId);
        if ($AssignedClassToTeacher) {
            parent::assignTeacher('NULL', $AssignedClassToTeacher->{'id'});
        }
        if($teacherId) {
            parent::assignTeacher($teacherId, $id);
            return true; 
        } else {
            parent::assignTeacher('NULL', $id);
        }
        return true;
    }

    public static function getTeacherName($teacherId)
    {
        $teacher = parent::findInOtherTableByColumn('users', 'id', $teacherId);
        if ($teacher) {
            return  $teacher->firstname . " " .  $teacher->lastname;
        }
        return false;
    }

    public static function getCount($id, $columnToCompare, $tableName)
    {

        $count = parent::countCompareById($id, $columnToCompare, $tableName);
        return $count->{"COUNT($tableName.$columnToCompare)"};
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

    public function getEnrolledClasses()
    {
        $enrolledClasses = parent::allOtherTable("enrolled_classes");
        return $enrolledClasses;
    }

    public function assignTeacher($teacherId, $classId)
    {
        parent::assignTeacher($teacherId, $classId);
    }
}
