<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CheckoutModel;
use App\Models\CartModel;
use App\Models\OrderItemsModel;

class CheckoutController extends Controller
{
    public function view()
    {
        if (!session()->get('is_logged_in')) {
            return redirect()->to(base_url('/login'));
        }

        return view('checkout/checkout');
    }

    public function display()
    {
        return view('checkout/thankyou');
    }

    public function process()
    {
        if (!session()->get('is_logged_in')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'You must be logged in to complete the checkout.',
            ]);
        }

        $validation = \Config\Services::validation();

        $validation->setRules([
            'city' => 'required',
            'fname' => 'required|min_length[2]',
            'lname' => 'required|min_length[2]',
            'address' => 'required|min_length[5]',
            'email' => 'required|valid_email',
            'phone' => 'required|min_length[10]',
            'notes' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors(),
            ]);
        }

        $checkoutModel = new CheckoutModel();
        $cartModel = new CartModel();

        $formData = $this->request->getPost();
        $cartItems = $cartModel->where('user_id', session('user_id'))->findAll();



        try {
            $db = \Config\Database::connect();
            $db->transStart();

            $orderId = $checkoutModel->insertOrder($formData, $cartItems);

            $cartModel->where('user_id', session('user_id'))->delete();

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Failed to place the order.');
            }

            return $this->response->setJSON([
                'status' => 'success',
                'order_id' => $orderId,
                'message' => 'Order placed successfully!',
            ]);
            if (empty($cartItems)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Your cart is empty.',
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to place the order. ' . $e->getMessage(),
            ]);
        }
    }
}
