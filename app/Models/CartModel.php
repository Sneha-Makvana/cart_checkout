<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table = 'cart';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'product_id', 'product_name', 'quantity', 'image', 'price', 'total_price'];

    public function getCartItems($userId)
    {
        return $this->where('user_id', $userId)->findAll();
    }
    
}
?>