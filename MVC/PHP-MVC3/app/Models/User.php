<?php

require_once __DIR__ . "/../Core/Database.php";

class User 
{
    /**
     * ទាញយក Users ទាំងអស់ពី Database (ឬ Mock data បើមិនទាន់មាន Table)
     */
    public static function all(): array 
    {
        try {
            $pdo = Database::connection();
            $stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            // បើ Database មិនទាន់បង្កើត Table `users` ទេ យើង return mock data ជាបណ្តោះអាសន្ន
            return [
                ['id' => 1, 'name' => 'សុខ ចាន់ដារ៉ា', 'email' => 'dara@example.com', 'role' => 'Admin'],
                ['id' => 2, 'name' => 'លី សុភា', 'email' => 'sophea@example.com', 'role' => 'Editor'],
                ['id' => 3, 'name' => 'គឹម សីហា', 'email' => 'seyha@example.com', 'role' => 'Member'],
            ];
        }
    }
}
