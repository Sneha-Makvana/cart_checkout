<?php

namespace App\Models;

use CodeIgniter\Model;

class CheckoutModel extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'order_id', 'product_id', 'product_name', 'qty', 'price', 'total_price'];
}
?>
