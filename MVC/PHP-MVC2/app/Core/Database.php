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

            try{
                self::$connection = new PDO(
                    $dsn,
                    $config['username'],
                    $config['password'],
                    $options
                );
            }catch(PDOException $e){
                die('Database Connection Failed: ' . $e->getMessage());
            }
        }
        return self::$connection;
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