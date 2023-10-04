<?php

namespace models;

use core\Application;
use core\DbModel;
use core\Model;

class Login extends User
{

    public string $email = "";
    public string $password = "";

    public function rules(): array
    {
        return [
            "email" => [self::RULE_REQUIRED, self::RULE_EMAIL],
            "password" => [self::RULE_REQUIRED, [self::RULE_MIN, "min" => 4], [self::RULE_MAX, "max" => 24]],
        ];
    }

    public function rulesUpdate(): array
    {
        return [
            // "email" => [self::RULE_REQUIRED, self::RULE_EMAIL],
            // "password" => [self::RULE_REQUIRED, [self::RULE_MIN, "min" => 6], [self::RULE_MAX, "max" => 24]],
        ];
    }

    public function login()
    {
        $user = DbModel::findOne(["email" => $this->email]);

        if (!$user) {
            $this->addError("email", "User does not exists with this email address");
            return false;
        }
        $password = $user->password;
        $statement = Application::$app->db->prepare("SELECT * FROM users WHERE `password` = PASSWORD('$password')");
        $isPassword = $statement->execute();

        if (!password_verify($this->password, $user->password) && !$isPassword) {
            $this->addError("password", "Password is incorrect");
            return false;
        }

        return Application::$app->login($user);
    }
}
