<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id_role' => 'EXP', 'role' => 'EXP Laner'],
            ['id_role' => 'GOLD', 'role' => 'Gold Laner'],
            ['id_role' => 'MID', 'role' => 'Mid Laner'],
            ['id_role' => 'JUNGLE', 'role' => 'Jungler'],
            ['id_role' => 'ROAM', 'role' => 'Roamer'],
        ];

        $this->db->table('role')->insertBatch($data);
    }
}
