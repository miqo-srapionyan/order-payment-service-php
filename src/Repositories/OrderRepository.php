<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Enums\OrderStatusEnum;
use App\Models\Order;
use PDO;

use function json_encode;

class OrderRepository
{
    /**
     * @var \PDO
     */
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * @param array $data
     *
     * @return \App\Models\Order
     */
    public function create(array $data): Order
    {
        $stmt = $this->db->prepare("INSERT INTO orders (user_id, items, total_price, status) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data['user_id'], json_encode($data['items']), $data['total_price'], OrderStatusEnum::SUCCESS->value]);
        $data['id'] = (int)$this->db->lastInsertId();

        return new Order($data);
    }
}
