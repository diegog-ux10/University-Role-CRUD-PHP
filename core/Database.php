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

    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $newMigrations = [];
        $files = scandir(dirname(__DIR__) . '/migrations');
        $toApplyMigrations = array_diff($files, $appliedMigrations);
        foreach ($toApplyMigrations as $migration) {
            if ($migration === "." || $migration === "..") {
                continue;
            }
            require_once dirname(__DIR__) . "/migrations/$migration";
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();
            echo "Applying Migration $migration" . PHP_EOL;
            $instance->up();
            echo "Applied Migration $migration" . PHP_EOL;
            $newMigrations[] = $migration;
            if (!empty($newMigrations)) {
                $this->saveMigrations($newMigrations);
            } else {
                echo "All migrations updated";
            }
        }
    }

    public function createMigrationsTable()
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations(
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;");
    }

    public function getAppliedMigrations()
    {
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function saveMigrations(array $migrations)
    {
        $str = implode(",", array_map(fn ($m) => "('$m')", $migrations));
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $str");
        $statement->execute();
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
