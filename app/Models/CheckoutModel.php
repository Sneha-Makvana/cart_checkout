<?php

namespace App\Models;

use CodeIgniter\Model;

class CheckoutModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'fname', 'lname', 'address', 'email', 'phone', 'notes', 'city'
    ];

    public function insertOrder($orderData, $cartItems)
    {
        $db = \Config\Database::connect();
    
        $this->insert($orderData);
        $orderId = $this->insertID();
    
        $orderItemsModel = new \App\Models\OrderItemsModel();
    
        foreach ($cartItems as $item) {
            $orderItemsModel->insert([
                'order_id' => $orderId,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
            ]);
        }
    
        return $orderId;
    }
    
}
