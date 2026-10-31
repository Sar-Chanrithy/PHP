<?php

class Product extends Model{
    protected string $table = 'products';

    public function getAll(): array{
        $stmt = Database::connection()->query("SELECT * FROM {$this->table} ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool{
        $stmt = Database::connection()->prepare(
            "INSERT INTO {$this->table} (title, price, stock, image, description)
            VALUES (:title, :price, :stock, :image, :description)"
        );
        return $stmt->execute([
            'title' => $data['title'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'image' => $data['image'],
            'description' => $data['description']
        ]);
    }

    public function find(int $id): ?array
    {
        $stmt = Database::connection()
            ->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function getById(int $id): ?array
    {
        return $this->find($id);
    }

    public function update(int $id, array $data): bool {
    $stmt = Database::connection()->prepare("
        UPDATE {$this->table}
        SET
            title = :title,
            price = :price,
            stock = :stock,
            image = :image,
            description = :description
        WHERE id = :id
    ");

    return $stmt->execute([
        'id' => $id,
        'title' => $data['title'],
        'price' => $data['price'],
        'stock' => $data['stock'],
        'image' => $data['image'],
        'description' => $data['description']
    ]);
}

    public function delete(int $id): bool
    {
        $stmt = Database::connection()
            ->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
