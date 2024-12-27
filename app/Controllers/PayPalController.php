<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\CheckoutModel;
use Config\PayPal;

class PayPalController extends BaseController
{
    public function createPayment()
    {
        $formData = $this->request->getPost();
        $cartItems = session()->get('cart');

        $checkoutModel = new CheckoutModel();
        $orderId = $checkoutModel->insertOrder($formData, $cartItems);

        $paypalConfig = new PayPal();
        $apiContext = $paypalConfig->getApiContext();

        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new \PayPal\Api\Amount();
        $amount->setTotal($formData['order_total']);
        $amount->setCurrency('USD');

        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription('Payment for Order #' . $orderId);

        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl(base_url('paypal/execute-payment?success=true'))
            ->setCancelUrl(base_url('paypal/execute-payment?success=false'));

        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions([$transaction])
            ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($apiContext);

            $transactionModel = new TransactionModel();
            $transactionModel->insert([
                'order_id' => $orderId,
                'transaction_id' => $payment->getId(),
                'payment_status' => 'pending',
                'payment_method' => 'paypal',
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            return $this->response->setJSON([
                'status' => 'success',
                'redirect_url' => $payment->getApprovalLink()
            ]);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            log_message('error', 'PayPal API Error: ' . $ex->getData());

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'PayPal error: ' . $ex->getMessage()
            ]);
        } catch (\Exception $ex) {
            log_message('error', 'General Error: ' . $ex->getMessage());

            return $this->response->setJSON([
                'status' => 'error',
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function executePayment()
    {
        $paymentId = $this->request->getGet('paymentId');
        $payerId = $this->request->getGet('PayerID');

        if (empty($paymentId) || empty($payerId)) {
            return view('paypal/cancel');
        }

        $paypalConfig = new PayPal();
        $apiContext = $paypalConfig->getApiContext();
        try {
            $payment = \PayPal\Api\Payment::get($paymentId, $apiContext);

            $execution = new \PayPal\Api\PaymentExecution();
            $execution->setPayerId($payerId);

            $result = $payment->execute($execution, $apiContext);

            // log_message('debug', 'Payment executed: ' . print_r($result, true));


            $transactionDetails = $result->getTransactions()[0];
            $relatedResources = $transactionDetails->getRelatedResources();
            $sale = $relatedResources[0]->getSale();
            $transactionId = $sale->getId(); // This is the PayPal transaction ID
            
            $transactionModel = new TransactionModel();
            $updateResult = $transactionModel->updateStatus($paymentId, [
                'payment_status' => 'completed',
                'transaction_id' => $transactionId,
            ]);

            if (!$updateResult) {
                log_message('error', 'Failed to update payment status for paymentId: ' . $paymentId);
            }

            return view('paypal/success', ['payment' => $result]);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            log_message('error', 'PayPal API Error: ' . $ex->getData());

            $transactionModel = new TransactionModel();
            $transactionModel->updateStatus($paymentId, [
                'payment_status' => 'failed',
            ]);

            return view('paypal/cancel', ['error' => $ex->getMessage()]);
        } catch (\Exception $ex) {

            log_message('error', 'General Error: ' . $ex->getMessage());



            $transactionModel = new TransactionModel();
            $transactionModel->updateStatus($paymentId, [
                'payment_status' => 'failed',

            ]);

            return view('paypal/cancel', ['error' => $ex->getMessage()]);
        }
    }
}
