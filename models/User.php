<?php

namespace models;

use core\Application;
use core\UserModel;

class User extends UserModel
{

    const ROL_ADMIN = 1;
    const ROL_TEACHER = 2;
    const ROL_STUDENT = 3;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    public string $firstname = '';
    public string $lastname = '';
    public string $password = '';
    public string $email = '';
    public string $address = '';
    public string $bday = '';
    public string $dni = '';
    public int $id_role = 1;
    public int $id_status = 1;
    public string $name = '';

    public function tableName(): string
    {
        return "users";
    }

    public static function primaryKey(): string
    {
        return "id";
    }

    public function save()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function updateUser($id, $role)
    {
        $password = $this->password;
        if ($password) {
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        }
        $role =  intval($role);
        $user = parent::get($id, 'users');
        if ($role !== $user->{"id_role"}) {
            if ($user->{"id_role"} === 2) {
                $classModel = new Classes();
                $AssignedClassToTeacher = $classModel->isTeacherAssign($user->{"id"});
                if ($AssignedClassToTeacher) {
                    $classModel->assignTeacher('NULL', $AssignedClassToTeacher->{'id'});
                } else {
                    return true;
                }
            } elseif ($user->{"id_role"} === 3) {
                $statement = Application::$app->db->pdo->prepare("DELETE FROM enrolled_classes WHERE id_student = $id");
                $statement->execute();
            }
        }
        parent::update($id);
        return true;
    }

    public function rules(): array
    {
        return [
            "email" => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, "class" => self::class]],
            // "password" => [self::RULE_REQUIRED, [self::RULE_MIN, "min" => 6], [self::RULE_MAX, "max" => 24]],
            "firstname" => [self::RULE_REQUIRED, [self::RULE_MIN, "min" => 3], [self::RULE_MAX, "max" => 100]],
            "lastname" => [self::RULE_REQUIRED, [self::RULE_MIN, "min" => 3], [self::RULE_MAX, "max" => 100]],
            "address" => [self::RULE_REQUIRED],
            "bday" => [self::RULE_REQUIRED],
            "dni" => [self::RULE_REQUIRED],
        ];
    }

    public function rulesUpdate(): array
    {
        return [
            // Reglas para actualizacion
        ];
    }


    public function attributes(): array
    {
        return ["email", "password", "firstname", "lastname", "address", "bday", "dni", "id_role", "id_status"];
    }

    public function getDisplayName(): string
    {
        return $this->name;
    }
}
