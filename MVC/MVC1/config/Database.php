<?php
/**
 * Database connection class using PDO
 */
class Database {
    private static $host = 'localhost';
    private static $db_name = 'mvc_db';
    private static $username = 'root';
    private static $password = '';
    private static $charset = 'utf8mb4';
    private static $connection = null;

    /**
     * Get singleton PDO connection instance
     * @return PDO
     */
    public static function getConnection() {
        if (self::$connection === null) {
            $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db_name . ";charset=" . self::$charset;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$connection = new PDO($dsn, self::$username, self::$password, $options);
            } catch (PDOException $e) {
                die("
                <div style='background:#0f172a; color:#f8fafc; font-family:sans-serif; min-height:100vh; display:flex; align-items:center; justify-content:center; padding:20px;'>
                    <div style='background:#1e293b; border:1px solid #334155; border-radius:12px; padding:30px; max-width:550px; text-align:center; box-shadow:0 10px 30px rgba(0,0,0,0.5);'>
                        <h2 style='color:#f87171; margin-bottom:12px;'>⚠️ Database Connection Failed</h2>
                        <p style='color:#94a3b8; font-size:14px; margin-bottom:20px;'>" . htmlspecialchars($e->getMessage()) . "</p>
                        <p style='margin-bottom:24px; color:#cbd5e1;'>Make sure <strong>MySQL</strong> is started in your XAMPP Control Panel, then click below to create the database.</p>
                        <a href='setup_database.php' style='display:inline-block; background:#38bdf8; color:#0f172a; text-decoration:none; font-weight:600; padding:12px 24px; border-radius:8px;'>Initialize Database Now &rarr;</a>
                    </div>
                </div>");
            }
        }

        return self::$connection;
    }
}
