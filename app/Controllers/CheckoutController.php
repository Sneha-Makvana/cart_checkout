<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProductModel;

class CheckoutController extends Controller
{
    public function view()
    {
        return view('checkout/checkout');
    }
}
?>