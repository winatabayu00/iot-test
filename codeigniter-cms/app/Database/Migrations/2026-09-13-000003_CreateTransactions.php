<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                 => ['type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true], // ponytail: signed IDs for PG+MySQL parity, ceiling 9.2e18
            'customer_id'        => ['type' => 'BIGINT', 'constraint' => 20, 'null' => false],
            'transaction_number' => ['type' => 'VARCHAR', 'constraint' => 40, 'null' => false],
            'payment_method'     => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => false],
            'total_amount'       => ['type' => 'NUMERIC', 'constraint' => '14,2', 'null' => false],
            'created_at'         => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'         => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('transaction_number');
        $this->forge->addKey('customer_id');
        $this->forge->addKey('created_at');
        $this->forge->addForeignKey('customer_id', 'customers', 'id', '', 'RESTRICT');
        $this->forge->createTable('transactions');
    }

    public function down()
    {
        $this->forge->dropTable('transactions');
    }
}
