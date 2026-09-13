<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\ProductModel;
use App\Services\TransactionService;

class TransactionController extends BaseController
{
    public function index(): string
    {
        $rows = \Config\Database::connect()->table('transactions t')
            ->select('t.*, c.name AS customer_name')
            ->join('customers c', 'c.id = t.customer_id')
            ->orderBy('t.id', 'DESC')->get()->getResultArray();

        return view('transactions/index', ['title' => 'Transactions', 'transactions' => $rows]);
    }

    public function new(): string
    {
        return view('transactions/form', [
            'title'     => 'New Transaction',
            'customers' => (new CustomerModel())->orderBy('name')->findAll(),
            'products'  => (new ProductModel())->where('stock >', 0)->orderBy('name')->findAll(),
        ]);
    }

    public function create()
    {
        $productIds = (array) $this->request->getPost('product_id');
        $quantities = (array) $this->request->getPost('quantity');
        $items      = [];
        foreach ($productIds as $i => $pid) {
            $items[] = ['product_id' => $pid, 'quantity' => $quantities[$i] ?? 0];
        }

        try {
            $id = (new TransactionService())->createTransaction([
                'customer_id'    => $this->request->getPost('customer_id'),
                'payment_method' => $this->request->getPost('payment_method') ?? 'cash',
                'items'          => $items,
            ]);
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to("/transactions/{$id}")->with('success', 'Transaction saved.');
    }

    public function show(int $id): string
    {
        $db = \Config\Database::connect();
        $trx = $db->table('transactions t')
            ->select('t.*, c.name AS customer_name, c.email AS customer_email')
            ->join('customers c', 'c.id = t.customer_id')
            ->where('t.id', $id)->get()->getRowArray();
        if ($trx === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Transaction #{$id}");
        }
        $items = $db->table('transaction_items i')
            ->select('i.*, p.name AS product_name')
            ->join('products p', 'p.id = i.product_id')
            ->where('i.transaction_id', $id)->get()->getResultArray();

        return view('transactions/show', ['title' => $trx['transaction_number'], 'trx' => $trx, 'items' => $items]);
    }
}
