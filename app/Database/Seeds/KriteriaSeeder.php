<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id_kriteria' => 'K1', 'kriteria' => 'Kill/Death/Assist (KDA)'],
            ['id_kriteria' => 'K2', 'kriteria' => 'Damage to Hero'],
            ['id_kriteria' => 'K3', 'kriteria' => 'Damage to Turret'],
            ['id_kriteria' => 'K4', 'kriteria' => 'Gold Earned'],
            ['id_kriteria' => 'K5', 'kriteria' => 'Damage Taken'],
            ['id_kriteria' => 'K6', 'kriteria' => 'Objective Control'],
            ['id_kriteria' => 'K7', 'kriteria' => 'Communication'],
            ['id_kriteria' => 'K8', 'kriteria' => 'Game Duration'],
        ];

        $this->db->table('kriteria')->insertBatch($data);
    }
}