<?php

namespace App\Models;

use CodeIgniter\Model;

class CheckoutModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id','fname', 'lname', 'address', 'email', 'phone', 'notes', 'city', 'total_amt'
    ];

    // public function insertOrder($formData, $cartItems)
    // {
    //     $orderData = [
    //         'user_id' => session('user_id'),
    //         'city' => $formData['city'],
    //         'fname' => $formData['fname'],
    //         'lname' => $formData['lname'],
    //         'address' => $formData['address'],
    //         'email' => $formData['email'],
    //         'phone' => $formData['phone'],
    //         'notes' => $formData['notes'],
    //         'total_amt' => $formData['order_total'],
    //         'status' => 'pending',
    //         'created_at' => date('Y-m-d H:i:s')
    //     ];
    //     $this->insert($orderData);
    //     $orderId = $this->insertID(); // Get the order ID after inserting


    //     // Check if $cartItems is an array and has items
    //     if (is_array($cartItems) && count($cartItems) > 0) {
    //         $orderItemsModel = new OrderItemsModel();
    //         foreach ($cartItems as $item) {
    //             $orderItemsModel->insert([
    //                 'order_id' => $orderId,
    //                 'product_id' => $item['product_id'],
    //                 'product_name' => $item['product_name'],
    //                 'quantity' => $item['quantity'],
    //                 'price' => $item['price'],
    //                 'total_price' => $item['total_price']
    //             ]);
    //         }
    //     } else {
    //         // Handle the case when cartItems is empty or null
    //         // You can log an error or return a response here if needed
    //         log_message('error', 'Cart items are empty or null.');
    //     }

    //     return $orderId;
    // }

    public function insertOrder($formData, $cartItems)
    {
        $orderData = [
            'user_id' => session('user_id'),
            'city' => $formData['city'],
            'fname' => $formData['fname'],
            'lname' => $formData['lname'],
            'address' => $formData['address'],
            'email' => $formData['email'],
            'phone' => $formData['phone'],
            'notes' => $formData['notes'],
            'total_amt' => $formData['order_total'],
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->insert($orderData);
        $orderId = $this->insertID(); 

        if (is_array($cartItems) && count($cartItems) > 0) {
            $orderItemsModel = new OrderItemsModel();
            foreach ($cartItems as $item) {
                $orderItemsModel->insert([
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product_name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total_price' => $item['total_price']
                ]);
            }
        } else {
            log_message('error', 'Cart items are empty or null.');
        }

        return $orderId;
    }
}
