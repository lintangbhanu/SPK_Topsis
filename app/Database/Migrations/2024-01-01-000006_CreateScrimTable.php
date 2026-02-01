<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateScrimTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_scrim' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_mlbb' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'scrim_ke' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'durasi' => [
                'type'       => 'TIME',
                'null'       => true,
            ],
            'total_kill' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'default'    => 0,
            ],
            'hero_digunakan' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'jumlah_kill' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'default'    => 0,
            ],
            'jumlah_death' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'default'    => 0,
            ],
            'jumlah_assist' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'default'    => 0,
            ],
            'damage_hero' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'null'       => true,
                'default'    => 0,
            ],
            'damage_turret' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'null'       => true,
                'default'    => 0,
            ],
            'damage_diterima' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'null'       => true,
                'default'    => 0,
            ],
            'jumlah_gold' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'null'       => true,
                'default'    => 0,
            ],
            'kontrol_objektif' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'default'    => 0,
            ],
            'komunikasi' => [
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

        $this->forge->addKey('id_scrim', true);
        $this->forge->addForeignKey('id_mlbb', 'pemain', 'id_mlbb', 'CASCADE', 'CASCADE');
        $this->forge->createTable('scrim');
    }

    public function down()
    {
        $this->forge->dropTable('scrim');
    }
}