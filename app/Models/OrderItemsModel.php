<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemsModel extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'order_id', 'product_id','user_id', 'quantity', 'product_name', 'price', 'total_price'
    ];
}
?>