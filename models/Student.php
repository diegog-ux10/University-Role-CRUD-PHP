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
        return ["email", "firstname", "lastname" , "address", "dni" ,"bday", "id_role"];
    }

    public function getAllStudents() {
        return parent::all();
    }
}
