<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionItemModel extends Model
{
    protected $table            = 'transaction_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = false;
    protected $allowedFields    = ['transaction_id', 'product_id', 'quantity', 'unit_price', 'subtotal'];
}
