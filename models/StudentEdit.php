<?php

namespace models;

use core\Application;
use core\UserModel;

class StudentEdit extends UserModel
{
    public string $email = '';
    public string $password = '';
    public string $firstname = '';
    public string $lastname = '';
    public string $address = '';
    public string $dni = '';
    public string $bday = '';
    public string $name = '';

    public function tableName(): string
    {
        return "students";
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
            "firstname" => [self::RULE_REQUIRED],
            "lastname" => [self::RULE_REQUIRED],
            "dni" => [self::RULE_REQUIRED],
            "address" => [self::RULE_REQUIRED],
            "bday" => [self::RULE_REQUIRED],
        ];
    }

    public function attributes(): array
    {
        return ["email", "password", "firstname", "lastname" , "address", "dni" ,"bday"];
    }

    public function update($id)
    {
        echo $id;
        $password = $this->password;
        if($password) {
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        }
        return parent::updated($id);
    }

    public function getDisplayName(): string
    {
        return $this->name;
    }
}