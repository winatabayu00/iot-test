<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionItems extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'BIGSERIAL', 'unsigned' => true, 'auto_increment' => true],
            'transaction_id' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => false],
            'product_id'     => ['type' => 'BIGINT', 'unsigned' => true, 'null' => false],
            'quantity'       => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'unit_price'     => ['type' => 'NUMERIC', 'constraint' => '14,2', 'null' => false],
            'subtotal'       => ['type' => 'NUMERIC', 'constraint' => '14,2', 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('transaction_id');
        $this->forge->addKey('product_id');
        $this->forge->addForeignKey('transaction_id', 'transactions', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'products', 'id', '', 'RESTRICT');
        $this->forge->createTable('transaction_items');
    }

    public function down()
    {
        $this->forge->dropTable('transaction_items');
    }
}
