<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProductModel;
use App\Models\CartModel;

class CartController extends Controller
{
    public function view()
    {
        $cartModel = new CartModel();
        $data['cartItems'] = $cartModel->findAll();
        return view('cart/cart', $data);
    }

    public function addToCart()
    {
        if ($this->request->isAJAX()) {
            $productId = $this->request->getPost('product_id');
            $quantity = $this->request->getPost('quantity');

            $productModel = new ProductModel();
            $cartModel = new CartModel();

            $product = $productModel->find($productId);

            if ($product) {
                $existingItem = $cartModel->where('product_name', $productId)->first();

                if ($existingItem) {
                    $newQuantity = $existingItem['qty'] + $quantity;
                    $newTotalPrice = $product['price'] * $newQuantity;

                    $cartModel->update($existingItem['id'], [
                        'qty' => $newQuantity,
                        'total_price' => $newTotalPrice,
                    ]);

                    return $this->response->setJSON([
                        'status' => 'success',
                        'message' => 'Product quantity updated in cart!',
                    ]);
                } else {
                    $cartData = [
                        'product_name' => $product['product_name'],
                        'price'        => $product['price'],
                        'image'        => $product['image'],
                        'qty'          => $quantity,
                        'total_price'  => $product['price'] * $quantity,
                    ];

                    $cartModel->insert($cartData);

                    return $this->response->setJSON([
                        'status' => 'success',
                        'message' => 'Product added to cart successfully!',
                    ]);
                }
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
            $cartModel = new CartModel();
            $cartItems = $cartModel->findAll();

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
            $cartModel = new CartModel();
            $cartItems = $cartModel->findAll();

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
            $cartId = $this->request->getPost('cart_id');
            $quantity = $this->request->getPost('quantity');

            $cartModel = new CartModel();
            $item = $cartModel->find($cartId);

            if ($item) {
                $newTotalPrice = $item['price'] * $quantity;

                $cartModel->update($cartId, [
                    'qty' => $quantity,
                    'total_price' => $newTotalPrice,
                ]);

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Cart item updated.',
                    'newTotalPrice' => $newTotalPrice,
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

    public function removeFromCart()
    {
        if ($this->request->isAJAX()) {
            $cartId = $this->request->getPost('cart_id');
            $cartModel = new CartModel();

            if ($cartModel->delete($cartId)) {
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
