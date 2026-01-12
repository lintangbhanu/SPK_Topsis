<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKriteriaTableHeru extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kriteria' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'kode_kriteria' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
            'nama_kriteria' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'atribut' => [
                'type' => 'ENUM',
                'constraint' => ['benefit', 'cost'],
            ],
            'bobot' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
            ],
        ]);
        $this->forge->addKey('id_kriteria', true);
        $this->forge->createTable('kriteria_heru');
    }

    public function down()
    {
        $this->forge->dropTable('kriteria_heru');
    }
}
