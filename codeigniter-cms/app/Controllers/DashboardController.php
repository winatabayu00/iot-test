<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\ProductModel;
use App\Models\TransactionModel;

class DashboardController extends BaseController
{
    public function index(): string
    {
        $db = \Config\Database::connect();

        return view('dashboard', [
            'title'              => 'Dashboard',
            'totalProducts'      => (new ProductModel())->countAll(),
            'totalCustomers'     => (new CustomerModel())->countAll(),
            'totalTransactions'  => (new TransactionModel())->countAll(),
            'totalSales'         => $db->table('transactions')->selectSum('total_amount', 'sum')->get()->getRowArray()['sum'] ?? 0,
            'recentTransactions' => $db->table('transactions t')
                ->select('t.*, c.name AS customer_name')
                ->join('customers c', 'c.id = t.customer_id')
                ->orderBy('t.id', 'DESC')->limit(10)->get()->getResultArray(),
        ]);
    }
}
