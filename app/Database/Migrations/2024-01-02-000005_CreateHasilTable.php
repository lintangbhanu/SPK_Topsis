<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHasilTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_hasil' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_karyawan' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'nilai_preferensi' => [
                'type' => 'DECIMAL',
                'constraint' => '10,4',
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'tanggal_hitung' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addKey('id_hasil', true);
        $this->forge->addForeignKey('id_karyawan', 'karyawan', 'id_karyawan', 'CASCADE', 'CASCADE');
        $this->forge->createTable('hasil');
    }

    public function down()
    {
        $this->forge->dropTable('hasil');
    }
}
