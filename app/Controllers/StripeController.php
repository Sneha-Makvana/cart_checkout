<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Config\StripeConfig;
use App\Models\CheckoutModel;
use App\Models\TransactionModel;

class StripeController extends Controller
{
    private $stripeConfig;

    public function __construct()
    {
        helper(['form']);
        $this->stripeConfig = new StripeConfig();
    }

    public function createCheckoutSession()
    {

        Stripe::setApiKey($this->stripeConfig->stripeSecretKey);

        $orderModel = new CheckoutModel();
        $formData = $this->request->getPost();

        $cartItems = $this->getCartItems();

        $orderId = $orderModel->insertOrder($formData, $cartItems);

        if (!$orderId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to create the order.']);
        }

        $totalAmount = $formData['order_total'];

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => ['name' => 'Order Payment'],
                        'unit_amount' => $totalAmount * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => base_url('/thankyou?session_id={CHECKOUT_SESSION_ID}&order_id=' . $orderId),
                'cancel_url' => base_url('cart'),
            ]);

            $transactionModel = new TransactionModel();
            $transactionModel->insert([
                'order_id' => $orderId,
                'transaction_id' => $session->id,
                'payment_status' => 'pending',
                'payment_method' => 'stripe',
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            return $this->response->setJSON([
                'status' => 'success',
                'redirect_url' => $session->url
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Stripe error: ' . $e->getMessage());
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function success()
    {
        $sessionId = $this->request->getGet('session_id');
        $orderId = $this->request->getGet('order_id');

        if (!$sessionId || !$orderId) {
            return view('payment_error', ['message' => 'Invalid session or order ID']);
        }

        \Stripe\Stripe::setApiKey($this->stripeConfig->stripeSecretKey);

        try {
            $session = \Stripe\Checkout\Session::retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                $transactionModel = new TransactionModel();
                $transaction = $transactionModel->where('transaction_id', $sessionId)->first();

                if ($transaction) {
                    $updateResult = $transactionModel->updateStatus($sessionId, [
                        'payment_status' => 'completed',
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                    if (!$updateResult) {
                        log_message('error', 'Failed to update payment status for sessionId: ' . $sessionId);
                    }
                } else {
                    log_message('error', 'Transaction not found for session ID: ' . $sessionId);
                }
            } else {
                log_message('error', 'Payment not completed for sessionId: ' . $sessionId);
            }
        } catch (\Exception $e) {
            log_message('error', 'Stripe error: ' . $e->getMessage());
            return view('payment_error', ['message' => 'An error occurred while verifying payment']);
        }
    }

    public function getCartItems()
    {
        return session()->get('cart') ?: [];
    }

    public function cancel()
    {
        return view('payment_cancel');
    }
}
