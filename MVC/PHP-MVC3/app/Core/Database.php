<?php

class Database
{
    private static ?PDO $connection = null;

    /**
     * Get or initialize PDO connection | ភ្ជាប់ ឬទាញយក PDO Connection
     *
     * @return PDO
     */

    public static function connection(): PDO
    {
        if (self::$connection === null) {
            self::loadEnv();

            $config = require __DIR__ . '/../../config/database.php';
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                $config['host'],
                $config['port'],
                $config['database'],
                $config['charset']
            );

            $options = [
                // Throw exceptions on SQL errors | បោះកំហុសជា PDOException ពេលមានបញ្ហា SQL
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                // Fetch associative arrays by default | ទាញយកទិន្នន័យជា Associative Array
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                // Use native prepared statements | ប្រើប្រាស់ Prepared Statements ពិតប្រាកដ
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            try {
                self::$connection = new PDO(
                    $dsn,
                    $config['username'],
                    $config['password'],
                    $options
                );
            } catch(PDOException $e) {
                // បើគ្មាន Database (Error 1049) ប្រព័ន្ធនឹង Auto-Create Database និង Table ជូនភ្លាម
                if ($e->getCode() == 1049 || str_contains($e->getMessage(), 'Unknown database')) {
                    self::autoCreateDatabaseAndTables($config, $options);
                } else {
                    die('Database Connection Failed: ' . $e->getMessage());
                }
            }
        }
        return self::$connection;
    }

    /**
     * Auto Create Database and Sample Tables
     */
    private static function autoCreateDatabaseAndTables(array $config, array $options): void
    {
        try {
            // ភ្ជាប់ទៅ MySQL server ដោយមិនចាំបាច់បញ្ជាក់ dbname
            $rootDsn = sprintf(
                'mysql:host=%s;port=%s;charset=%s',
                $config['host'],
                $config['port'],
                $config['charset']
            );
            $rootPdo = new PDO($rootDsn, $config['username'], $config['password'], $options);

            // បង្កើត Database បើមិនទាន់មាន
            $dbName = $config['database'];
            $rootPdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

            // ភ្ជាប់ទៅកាន់ Database ដែលទើបបង្កើតរួច
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                $config['host'],
                $config['port'],
                $config['database'],
                $config['charset']
            );
            self::$connection = new PDO($dsn, $config['username'], $config['password'], $options);

            // បង្កើត Table users
            self::$connection->exec("
                CREATE TABLE IF NOT EXISTS `users` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `name` VARCHAR(100) NOT NULL,
                    `email` VARCHAR(100) NOT NULL,
                    `role` VARCHAR(50) DEFAULT 'User',
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ");

            // បញ្ចូលទិន្នន័យគំរូប្រសិនបើ Table នៅទំនេរ
            $count = self::$connection->query("SELECT COUNT(*) FROM `users`")->fetchColumn();
            if ($count == 0) {
                self::$connection->exec("
                    INSERT INTO `users` (`name`, `email`, `role`) VALUES
                    ('សុខ ចាន់ដារ៉ា', 'dara@example.com', 'Admin'),
                    ('លី សុភា', 'sophea@example.com', 'Editor'),
                    ('គឹម សីហា', 'seyha@example.com', 'Member');
                ");
            }
        } catch (PDOException $ex) {
            die('Auto-Create Database Failed: ' . $ex->getMessage());
        }
    }

    private static function loadEnv(): void
    {
        $envFile = __DIR__ . '/../../.env';
        if (!file_exists($envFile)) {
            return;
        }

        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            if (str_contains($line, '=')) {
                [$key, $value] = explode('=', $line, 2);
                // $key = DB_HOST
                // $value = 127.0.0.1
                $key = trim($key);
                $value = trim($value, " \t\n\r\0\x0B\"'");

                if (!array_key_exists($key, $_ENV)) {
                    putenv("$key=$value");
                }
            }
        }
    }
}