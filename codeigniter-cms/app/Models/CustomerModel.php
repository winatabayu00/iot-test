<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table            = 'customers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $allowedFields    = ['name', 'email', 'phone'];

    protected $validationRules = [
        'name'  => 'required|max_length[150]',
        'email' => 'permit_empty|valid_email|max_length[190]',
        'phone' => 'permit_empty|max_length[30]',
    ];

    protected $validationMessages = [
        'name'  => ['required' => 'Customer name is required.'],
        'email' => ['valid_email' => 'Email address is not valid.'],
    ];
}
