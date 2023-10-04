<?php

namespace models;

use core\Application;
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

    public function isTeacherAssign($teacher_id)
    {
        $AssignedClassToTeacher = parent::findOne(["id_teacher" => $teacher_id]);
        if ($AssignedClassToTeacher) {
            return $AssignedClassToTeacher;
        } else {
            return false;
        }
    }

    public function saveClass($teacher_id)
    {
        $createdClass = parent::save();
        if ($teacher_id) {
            $user = User::get($teacher_id, "users");
            $AssignedClassToTeacher = $this->isTeacherAssign($teacher_id);
            if ($AssignedClassToTeacher) {
                parent::assignTeacher('NULL', $AssignedClassToTeacher->{'id'});
            }
            parent::assignTeacher($user->{'id'}, $createdClass->{'id'});
            return true;
        }
        return true;
    }

    public function updateClass($id, $teacher_id)
    {
        parent::update($id);
        $AssignedClassToTeacher = $this->isTeacherAssign($teacher_id);
        if ($AssignedClassToTeacher) {
            parent::assignTeacher('NULL', $AssignedClassToTeacher->{'id'});
        }
        if ($teacher_id) {
            parent::assignTeacher($teacher_id, $id);
            return true;
        } else {
            parent::assignTeacher('NULL', $id);
        }
        return true;
    }

    public static function getTeacherName($teacher_id)
    {
        $teacher = parent::findInOtherTableByColumn('users', 'id', $teacher_id);
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

    public function getEnrolledClasses($id)
    {
        $enrolled_classes = parent::findAllinOtherTable("enrolled_classes", ["id_student" => $id]);
        return $enrolled_classes;
    }

    public function assignTeacher($teacher_id, $class_id)
    {
        parent::assignTeacher($teacher_id, $class_id);
    }

    public function deleteEnrolledClass($class_id, $student_id)
    {
        $statement = Application::$app->db->pdo->prepare("DELETE FROM enrolled_classes WHERE id_student = $student_id AND id_class = $class_id");
        return $statement->execute();
    }

    public function registerClasses($classesId, $student_id)
    {
        foreach ($classesId as $class_id) {
            $class_id = intval($class_id);
            $statement = Application::$app->db->pdo->prepare("INSERT INTO enrolled_classes (id_class, id_student) VALUES ($class_id, $student_id)");
            $statement->execute();
        }
        return true;
    }

    public static function getNotRegisteredClass($user_id)
    {
        $statement = Application::$app->db->pdo->prepare("SELECT * FROM classes WHERE id_student != $user_id");
        $statement->execute();
        return $statement->fetchAll();
    }
    
    public function getDataClasses($classes)
    {
        $data = [];
        foreach ($classes as $class) {
            if ($class["id_teacher"]) {
                $teacher_name = self::getTeacherName($class["id_teacher"]);
            } else {
                $teacher_name = "Sin asignar";
            }
            $enrolled_students = self::getCount($class["id"], 'id_class', 'enrolled_classes');
            if ($enrolled_students === 0) {
                $enrolled_students = "Sin Alumnos";
            }
            $data[] = ["id" => $class["id"], "name" => $class["name"], "teacher" => $teacher_name, "enrolled_students" => $enrolled_students];
        }
        return $data;
    }
}
