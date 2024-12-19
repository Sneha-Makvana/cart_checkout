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

    public function display($id)
    {
        $productModel = new ProductModel();

        $product = $productModel->find($id);

        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Product with ID $id not found.");
        }

        $data['product'] = $product;

        return view('product/singleProduct', $data);
    }
}
