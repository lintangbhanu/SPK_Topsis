<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKriteriaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kriteria' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
            'kriteria' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
        ]);
        $this->forge->addKey('id_kriteria', true);
        $this->forge->createTable('kriteria');
    }

    public function down()
    {
        $this->forge->dropTable('kriteria');
    }
}
