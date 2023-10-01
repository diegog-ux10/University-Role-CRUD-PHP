<?php

namespace models;

use core\Application;
use core\UserModel;

class User extends UserModel
{

    const ROL_ADMIN = 1;
    const ROL_TEACHER = 2;
    const ROL_STUDENT = 3;

    public string $email = '';
    public string $password = '';
    public string $firstname = '';
    public string $lastname = '';
    public string $address = '';
    public string $phone = '';
    public string $bday = '';
    public string $name = '';
    public int $rol = self::ROL_ADMIN;

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

    public function rules(): array
    {
        return [
            "email" => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, "class" => self::class]],
            "password" => [self::RULE_REQUIRED, [self::RULE_MIN, "min" => 6], [self::RULE_MAX, "max" => 24]],
        ];
    }

    public function attributes(): array
    {
        return ["email", "password", "name", "bio", "phone", "photo", "status"];
    }

    public function getDisplayName(): string
    {
        return $this->name;
    }
}
