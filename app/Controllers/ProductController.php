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
    public function product()
    {
        $productModel = new ProductModel();

        $data['products'] = $productModel->findAll();

        return view('product/main', $data);
    }
    public function create()
    {
        return view('product/product');
    }

    public function fetchProducts()
    {
        if ($this->request->isAJAX()) {
            $productModel = new ProductModel();

            $search = $this->request->getPost('search') ?? '';
            $category = $this->request->getPost('category') ?? '';
            $page = (int)($this->request->getPost('page') ?? 1);
            $perPage = 3;
            $offset = ($page - 1) * $perPage;

            $builder = $productModel->builder();

            if (!empty($search)) {
                $builder->like('product_name', $search);
            }

            if (!empty($category)) {
                $builder->where('category', $category);
            }

            $totalCount = $builder->countAllResults(false);
            $products = $builder->limit($perPage, $offset)->get()->getResultArray();

            return $this->response->setJSON([
                'products' => $products,
                'total_count' => $totalCount,
                'current_page' => $page,
                'per_page' => $perPage,
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Invalid request',
        ]);
    }
}
