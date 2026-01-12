<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateThresholdTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_threshold' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_kriteria' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'nilai' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
        ]);
        $this->forge->addKey('id_threshold', true);
        $this->forge->addForeignKey('id_kriteria', 'kriteria_heru', 'id_kriteria', 'CASCADE', 'CASCADE');
        $this->forge->createTable('threshold');
    }

    public function down()
    {
        $this->forge->dropTable('threshold');
    }
}
