<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Models\Product;
use PDO;

use function implode;
use function array_fill;
use function count;

class ProductRepository
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
     * Find products by their IDs.
     *
     * @param array $productIds List of product IDs to fetch.
     *
     * @return array Associative array of Product objects indexed by product ID.
     */
    public function findByIds(array $productIds): array
    {
        // Example of fetching products in one query
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id IN (".implode(',', array_fill(0, count($productIds), '?')).")");
        $stmt->execute($productIds);

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $productObjects = [];
        foreach ($products as $product) {
            // Assuming you have a Product class that can be instantiated like this
            $productObjects[$product['id']] = new Product($product);
        }

        return $productObjects;
    }

    /**
     * @param int $productId
     * @param int $quantity
     *
     * @return bool
     */
    public function decreaseStock(int $productId, int $quantity): bool
    {
        $stmt = $this->db->prepare("UPDATE products SET stock = stock - ? WHERE id = ? AND stock >= ?");
        $stmt->execute([$quantity, $productId, $quantity]);

        return $stmt->rowCount() > 0; // Returns true if the update was successful
    }
}
