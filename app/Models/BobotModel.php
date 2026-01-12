<?php

namespace App\Models;

use CodeIgniter\Model;

class BobotModel extends Model
{
    protected $table = 'bobot';
    protected $primaryKey = 'id_bobot';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['id_bobot', 'id_role', 'id_kriteria', 'skor', 'bobot', 'atribut'];
    protected $useTimestamps = false;
}
