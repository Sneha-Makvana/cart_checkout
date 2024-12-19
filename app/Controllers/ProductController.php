<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProductModel;

class ProductController extends Controller
{
    public function view()
    {
        $productModel = new ProductModel();

        $data['products'] = $productModel->findAll();

        return view('product/main', $data);
    }
    public function display()
    {
        return view('product/singleProduct');
    }
}
