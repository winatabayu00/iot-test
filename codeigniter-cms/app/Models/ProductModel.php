<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $allowedFields    = ['name', 'description', 'price', 'stock'];

    protected $validationRules = [
        'name'  => 'required|max_length[180]',
        'price' => 'required|decimal|greater_than[0]',
        'stock' => 'required|integer|greater_than_equal_to[0]',
    ];

    protected $validationMessages = [
        'name'  => ['required' => 'Product name is required.'],
        'price' => [
            'required'     => 'Price is required.',
            'greater_than' => 'Price must be greater than 0.',
        ],
        'stock' => [
            'required'                => 'Stock is required.',
            'greater_than_equal_to'   => 'Stock cannot be negative.',
        ],
    ];
}
