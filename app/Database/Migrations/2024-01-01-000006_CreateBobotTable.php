<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBobotTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_bobot' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'id_role' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
            'id_kriteria' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
            'skor' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'bobot' => [
                'type' => 'DECIMAL',
                'constraint' => '10,9',
                'null' => true,
            ],
            'atribut' => [
                'type' => 'ENUM',
                'constraint' => ['benefit', 'cost'],
                'default' => 'benefit',
            ],
        ]);
        $this->forge->addKey('id_bobot', true);
        $this->forge->addForeignKey('id_role', 'role', 'id_role', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_kriteria', 'kriteria', 'id_kriteria', 'CASCADE', 'CASCADE');
        $this->forge->createTable('bobot');
    }

    public function down()
    {
        $this->forge->dropTable('bobot');
    }
}
