<?php

namespace core;

class Database
{
    public \PDO $pdo;

    public function __construct($config)
    {
        $this->pdo = new \PDO($config["db_dsb"], $config["db_user"], $config["db_password"]);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }

    public function  log($message)
    {
        echo '[' . date('Y-m-d H:i:s') . '] - ' . $message . PHP_EOL;
    }

    public function getUserData(string $userId)
    {
        $statement = $this->pdo->prepare("SELECT * FROM users WHERE id = $userId");
        $statement->execute();

        return $statement->fetch();
    }

    public function updateUser(string $userId, string $sql)
    {
        $statement = $this->pdo->prepare("SELECT * FROM users WHERE id = $userId");
    }
}
