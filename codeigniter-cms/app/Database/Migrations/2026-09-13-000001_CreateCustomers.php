<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true], // ponytail: signed IDs for PG+MySQL parity, ceiling 9.2e18
            'name'       => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => false],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 190, 'null' => true],
            'phone'      => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('customers');
    }

    public function down()
    {
        $this->forge->dropTable('customers');
    }
}
