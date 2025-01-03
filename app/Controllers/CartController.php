<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProductModel;
use App\Models\CartModel;

class CartController extends Controller
{
    public function view()
    {
        $session = session();
        $cartItems = $session->get('cart_items') ?? [];

        $data['cartItems'] = $cartItems;
        return view('cart/cart', $data);
    }

    public function addToCart()
    {
        if ($this->request->isAJAX()) {
            $session = session();
            $productId = $this->request->getPost('product_id');
            $quantity = $this->request->getPost('quantity');
            $userId = 1;

            $productModel = new ProductModel();
            $cartModel = new CartModel();

            $product = $productModel->find($productId);

            if ($product) {
                $existingCartItem = $cartModel->where([
                    'user_id' => $userId,
                    'product_id' => $productId
                ])->first();

                if ($existingCartItem) {
                    $newQuantity = $existingCartItem['quantity'] + $quantity;
                    $newTotalPrice = $newQuantity * $product['price'];

                    $cartModel->update($existingCartItem['id'], [
                        'quantity' => $newQuantity,
                        'total_price' => $newTotalPrice,
                    ]);
                } else {
                    $cartModel->insert([
                        'user_id' => $userId,
                        'product_id' => $productId,
                        'product_name' => $product['product_name'],
                        'price' => $product['price'],
                        'image' => $product['image'],
                        'quantity' => $quantity,
                        'total_price' => $product['price'] * $quantity,
                    ]);
                }

                $cartItems = $session->get('cart_items') ?? [];
                if (isset($cartItems[$productId])) {
                    $cartItems[$productId]['quantity'] += $quantity;
                    $cartItems[$productId]['total_price'] = $cartItems[$productId]['quantity'] * $product['price'];
                } else {
                    $cartItems[$productId] = [
                        'product_name' => $product['product_name'],
                        'price' => $product['price'],
                        'image' => $product['image'],
                        'quantity' => $quantity,
                        'total_price' => $product['price'] * $quantity,
                    ];
                }
                $session->set('cart_items', $cartItems);

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Product added to cart successfully!',
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Product not found.',
                ]);
            }
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Invalid request.',
        ]);
    }

    public function getCartCount()
    {
        if ($this->request->isAJAX()) {
            $session = session();
            $cartItems = $session->get('cart_items') ?? [];
            $itemCount = count($cartItems);

            return $this->response->setJSON([
                'status' => 'success',
                'count' => $itemCount,
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Invalid request.',
        ]);
    }

    public function getCartTotals()
    {
        if ($this->request->isAJAX()) {
            $session = session();
            $cartItems = $session->get('cart_items') ?? [];

            $subtotal = 0;

            foreach ($cartItems as $item) {
                $subtotal += $item['total_price'];
            }

            return $this->response->setJSON([
                'status' => 'success',
                'subtotal' => $subtotal,
                'total' => $subtotal,
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Invalid request.',
        ]);
    }

    public function updateCartItem()
    {
        if ($this->request->isAJAX()) {
            $session = session();
            $productId = $this->request->getPost('cart_id');
            $quantity = $this->request->getPost('quantity');

            $cartItems = $session->get('cart_items') ?? [];

            if (isset($cartItems[$productId])) {
                $cartItems[$productId]['quantity'] = $quantity;
                $cartItems[$productId]['total_price'] = $cartItems[$productId]['quantity'] * $cartItems[$productId]['price'];

                $cartModel = new CartModel();
                $cartModel->update($productId, [
                    'quantity' => $cartItems[$productId]['quantity'],
                    'total_price' => $cartItems[$productId]['total_price']
                ]);

                $session->set('cart_items', $cartItems);

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Cart item updated.',
                    'newTotalPrice' => $cartItems[$productId]['total_price'],
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Cart item not found.',
                ]);
            }
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Invalid request.',
        ]);
    }


    public function removeFromCart($productId)
    {
        if ($this->request->isAJAX()) {
            $session = session();
            $cartItems = $session->get('cart_items') ?? [];

            if (isset($cartItems[$productId])) {
                unset($cartItems[$productId]);

                $session->set('cart_items', $cartItems);

                $cartModel = new CartModel();
                $cartModel->where('product_id', $productId)->delete();

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Item removed from cart.',
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to remove item from cart.',
                ]);
            }
        }
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Invalid request.',
        ]);
    }

    
}


