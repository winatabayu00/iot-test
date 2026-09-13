<?php

namespace App\Controllers;

use App\Models\ProductModel;

class ProductController extends BaseController
{
    public function index(): string
    {
        return view('products/index', [
            'title'    => 'Products',
            'products' => (new ProductModel())->orderBy('id', 'DESC')->findAll(),
        ]);
    }

    public function new(): string
    {
        return view('products/form', ['title' => 'New Product', 'product' => []]);
    }

    public function create()
    {
        $model = new ProductModel();
        if (! $model->insert($this->request->getPost(['name', 'description', 'price', 'stock']))) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to('/products')->with('success', 'Product created.');
    }

    public function edit(int $id): string
    {
        $product = (new ProductModel())->find($id);
        if ($product === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Product #{$id}");
        }

        return view('products/form', ['title' => 'Edit Product', 'product' => $product]);
    }

    public function update(int $id)
    {
        $model = new ProductModel();
        if (! $model->update($id, $this->request->getPost(['name', 'description', 'price', 'stock']))) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to('/products')->with('success', 'Product updated.');
    }

    public function delete(int $id)
    {
        try {
            (new ProductModel())->delete($id);
        } catch (\Throwable $e) {
            // FK RESTRICT: product already referenced by transaction_items.
            return redirect()->to('/products')->with('error', 'Cannot delete: product is used in transaction history.');
        }

        return redirect()->to('/products')->with('success', 'Product deleted.');
    }
}
