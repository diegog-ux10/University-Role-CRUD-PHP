<?php

namespace models;

use core\Application;
use core\UserModel;

class Teacher extends User
{
    public int $id_role = 2;
    public string $password = 'maestro';

    public function rules(): array
    {
        return [
            "email" => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, "class" => self::class]],
            "password" => [self::RULE_REQUIRED, [self::RULE_MIN, "min" => 6], [self::RULE_MAX, "max" => 24]],
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


    public function saveTeacher($class_id)
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $createdUser = parent::save();
        if ($class_id) {
            $class = Classes::get($class_id, "classes");
            $class->assignTeacher($createdUser->{'id'}, $class->{'id'});
            return true;
        }
        return true;
    }

    public function updateTeacher($teacher_id, $class_id)
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        parent::update($teacher_id);
        $class = new Classes();
        if ($class_id) {
            $class = Classes::get($class_id, "classes");
            $class->assignTeacher($teacher_id, $class->{'id'});
        } else {
            $AssignedClassToTeacher = $class->isTeacherAssign($teacher_id);
            if ($AssignedClassToTeacher) {
                $class->assignTeacher('NULL', $AssignedClassToTeacher->{'id'});
            }
        }
        return true;
    }


    public static function getAsignedClass($id)
    {
        return parent::findInOtherTableByColumn("classes", "id_teacher", $id);
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

    public function getDataTeachers($users)
    {
        $data = [];
        foreach ($users as $user) {
            if ($user["id_role"] !== 2) {
                continue;
            }
            $teacher_name = $user["firstname"] . " " . $user["lastname"];
            $assigned_class = self::getAsignedClass($user["id"]);
            if ($assigned_class) {
                $assignedClassName = $assigned_class->name;
            } else {
                $assignedClassName = "Sin Asignar";
            }
            $data[] = ["id" => $user["id"], "name" => $teacher_name, "email" => $user["email"], "address" => $user["address"], "bday" => $user["bday"], "assigned_class" => $assignedClassName];
        }
        return $data;
    }
}
