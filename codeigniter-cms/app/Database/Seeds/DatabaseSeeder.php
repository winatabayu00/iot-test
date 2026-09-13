<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $this->db->table('customers')->insertBatch([
            ['name' => 'Budi Santoso', 'email' => 'budi@example.com', 'phone' => '081234567890', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Siti Aminah', 'email' => 'siti@example.com', 'phone' => '081298765432', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Andi Wijaya', 'email' => null, 'phone' => '081377788899', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Dewi Lestari', 'email' => 'dewi@example.com', 'phone' => null, 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->db->table('products')->insertBatch([
            ['name' => 'Kopi Arabika 250g', 'description' => 'Biji kopi arabika sangrai medium.', 'price' => '85000.00', 'stock' => 50, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Teh Hijau 100g', 'description' => 'Teh hijau premium.', 'price' => '45000.00', 'stock' => 30, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Gula Aren 500g', 'description' => 'Gula aren asli.', 'price' => '32000.00', 'stock' => 100, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Madu Hutan 300ml', 'description' => 'Madu hutan murni.', 'price' => '120000.00', 'stock' => 20, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Cokelat Bubuk 200g', 'description' => 'Cokelat bubuk tanpa pemanis.', 'price' => '55000.00', 'stock' => 40, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Susu Oat 1L', 'description' => 'Susu oat plain.', 'price' => '38000.00', 'stock' => 60, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
