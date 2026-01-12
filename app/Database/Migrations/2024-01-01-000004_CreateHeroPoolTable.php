<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHeroPoolTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pool' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_mlbb' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'hero' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
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
        $this->forge->addKey('id_pool', true);
        $this->forge->addForeignKey('id_mlbb', 'pemain', 'id_mlbb', 'CASCADE', 'CASCADE');
        $this->forge->createTable('heropool');
    }

    public function down()
    {
        $this->forge->dropTable('heropool');
    }
}
