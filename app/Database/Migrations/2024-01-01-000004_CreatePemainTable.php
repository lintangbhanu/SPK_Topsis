<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePemainTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_mlbb' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'nickname' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'id_role' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
            ],
            'rank' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'winrate' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => true,
            ],
            'kompetisi_menang' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_mlbb', true);
        $this->forge->addForeignKey('id_role', 'role', 'id_role', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pemain');
    }

    public function down()
    {
        $this->forge->dropTable('pemain');
    }
}