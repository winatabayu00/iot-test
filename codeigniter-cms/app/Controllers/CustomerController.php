<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class CustomerController extends BaseController
{
    public function index(): string
    {
        return view('customers/index', [
            'title'     => 'Customers',
            'customers' => (new CustomerModel())->orderBy('id', 'DESC')->findAll(),
        ]);
    }

    public function new(): string
    {
        return view('customers/form', ['title' => 'New Customer', 'customer' => []]);
    }

    public function create()
    {
        $model = new CustomerModel();
        if (! $model->insert($this->request->getPost(['name', 'email', 'phone']))) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to('/customers')->with('success', 'Customer created.');
    }

    public function edit(int $id): string
    {
        $customer = (new CustomerModel())->find($id);
        if ($customer === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Customer #{$id}");
        }

        return view('customers/form', ['title' => 'Edit Customer', 'customer' => $customer]);
    }

    public function update(int $id)
    {
        $model = new CustomerModel();
        if (! $model->update($id, $this->request->getPost(['name', 'email', 'phone']))) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to('/customers')->with('success', 'Customer updated.');
    }

    public function delete(int $id)
    {
        try {
            (new CustomerModel())->delete($id);
        } catch (\Throwable $e) {
            // FK RESTRICT: customer already has transactions.
            return redirect()->to('/customers')->with('error', 'Cannot delete: customer has transaction history.');
        }

        return redirect()->to('/customers')->with('success', 'Customer deleted.');
    }
}
