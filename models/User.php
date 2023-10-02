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
    public int | null $id_class = null;
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

    public function update($id)
    {
        $password = $this->password;
        if ($password) {
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        }
        return parent::updated($id);
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
            // "email" => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, "class" => self::class]],
            // // "password" => [self::RULE_REQUIRED, [self::RULE_MIN, "min" => 6], [self::RULE_MAX, "max" => 24]],
            // "firstname" => [self::RULE_REQUIRED, [self::RULE_MIN, "min" => 3], [self::RULE_MAX, "max" => 100]],
            // "lastname" => [self::RULE_REQUIRED, [self::RULE_MIN, "min" => 3], [self::RULE_MAX, "max" => 100]],
            // "address" => [self::RULE_REQUIRED],
            // "bday" => [self::RULE_REQUIRED],
        ];
    }


    public function attributes(): array
    {
        return ["email", "password", "firstname", "lastname", "address", "bday", "dni", "id_role", "id_status", "id_class"];
    }

    public function getDisplayName(): string
    {
        return $this->name;
    }
}
