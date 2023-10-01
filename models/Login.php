<?php

namespace models;

use core\Application;
use core\Model;

class Login extends Model
{

    public string $email = "";
    public string $password = "";

    public function rules(): array
    {
        return [
            "email" => [self::RULE_REQUIRED, self::RULE_EMAIL],
            "password" => [self::RULE_REQUIRED, [self::RULE_MIN, "min" => 6], [self::RULE_MAX, "max" => 24]],
        ];
    }

    public function login()
    {
        $user = User::findOne(["email" => $this->email]);

        if (!$user) {
            $this->addError("email", "User does not exists with this email address");
            return false;
        }
        if (!password_verify($this->password, $user->password)) {
            $this->addError("password", "Password is incorrect");
            return false;
        }
        return Application::$app->login($user);
    }
}
