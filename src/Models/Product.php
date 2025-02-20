<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Class Product
 *
 * @package App\Models
 *
 * @property int    $id
 * @property string $name
 * @property float  $price
 * @property int    $stock
 */
class Product extends Model
{
    protected int $id;
    protected string $name;
    protected float $price;
    protected int $stock;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->price = $data['price'];
        $this->stock = $data['stock'];
    }
}
