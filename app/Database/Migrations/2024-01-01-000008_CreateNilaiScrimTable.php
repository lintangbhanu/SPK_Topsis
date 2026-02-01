<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNilaiScrimTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_nilai' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_scrim' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_kriteria' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
            ],
            'nilai' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id_nilai', true);
        $this->forge->addForeignKey('id_scrim', 'scrim', 'id_scrim', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_kriteria', 'kriteria', 'id_kriteria', 'CASCADE', 'CASCADE');
        $this->forge->createTable('nilai_scrim');
    }

    public function down()
    {
        $this->forge->dropTable('nilai_scrim');
    }
}