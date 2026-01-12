<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateScrimTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_scrim' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_mlbb' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'scrim_ke' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'durasi' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'total_kill' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'hero_digunakan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'jumlah_kill' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'jumlah_death' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'jumlah_assist' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'damage_hero' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'damage_turret' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'damage_diterima' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'jumlah_gold' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'kontrol_objektif' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'komunikasi' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
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
