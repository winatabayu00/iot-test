<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProducts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'BIGSERIAL', 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 180, 'null' => false],
            'description' => ['type' => 'TEXT', 'null' => true],
            'price'       => ['type' => 'NUMERIC', 'constraint' => '14,2', 'null' => false],
            'stock'       => ['type' => 'INT', 'constraint' => 11, 'null' => false, 'default' => 0],
            'created_at'  => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'  => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('name');
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
