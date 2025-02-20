<?php

declare(strict_types=1);

namespace App\Models;

use function json_encode;

/**
 * Class Order
 *
 * @package App\Models
 *
 * @property int    $id
 * @property string $items
 * @property int    $user_id
 * @property float  $total_price
 * @property int $status
 */
class Order extends Model
{
    protected int $id;
    protected int $user_id;
    protected string $items;
    protected float $total_price;
    protected int $status;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? 0;
        $this->user_id = $data['user_id'];
        $this->items = json_encode($data['items']);
        $this->total_price = $data['total_price'];
        $this->status = $data['status'];
    }
}
