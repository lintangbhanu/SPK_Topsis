<?php

namespace App\Models;

use CodeIgniter\Model;

class PemainModel extends Model
{
    protected $table = 'pemain';
    protected $primaryKey = 'id_mlbb';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['id_mlbb', 'nickname', 'nama', 'id_role', 'rank', 'winrate', 'kompetisi_menang'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
