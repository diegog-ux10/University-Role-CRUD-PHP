<?php

namespace models;

use core\Application;
use core\UserModel;

class Student extends User
{
    public int $id_role = 3;

    public function rules(): array
    {
        return [
            "email" => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, "class" => self::class]],
            "firstname" => [self::RULE_REQUIRED],
            "lastname" => [self::RULE_REQUIRED],
            "dni" => [self::RULE_REQUIRED],
            "address" => [self::RULE_REQUIRED],
            "bday" => [self::RULE_REQUIRED],
        ];
    }

    public function attributes(): array
    {
        return ["email", "firstname", "lastname", "address", "dni", "bday", "id_role"];
    }

    public static function getEnrolledClassesByStudentId($student_id)
    {
        parent::findAllinOtherTable("enrolled_classes", ["id_student" => $student_id]);
    }

    public function getAllAssignedStudents($user_id)
    {
        $data = [];
        $statement = Application::$app->db->pdo->prepare("SELECT * FROM classes WHERE id_teacher = $user_id");
        $statement->execute();
        $class = $statement->fetchObject();
        if ($class) {
            $class_id = $class->{'id'};
            $statement = Application::$app->db->pdo->prepare("SELECT * FROM enrolled_classes WHERE id_class = $class_id");
            $statement->execute();
            $registered_students = $statement->fetchAll();
            $data = [];
            foreach ($registered_students as $register) {
                $student_id = $register['id_student'];
                $statement = Application::$app->db->pdo->prepare("SELECT * FROM users WHERE id = $student_id");
                $statement->execute();
                $student = $statement->fetchObject();
                $data[] = $student;
            }
        }
        return $data;
    }

    public function getAllStudents($users)
    {
        $data = [];
        foreach ($users as $user) {
            if ($user["id_role"] !== 3) {
                continue;
            }
            $enrolled_classes = self::getEnrolledClassesByStudentId($user["id"]);
            $user["enrolled_classes"] = $enrolled_classes;
            $data[] = $user;
        }
        return $data;
    }
}
