<?php

namespace App\Models;

use CodeIgniter\Model;

class KriteriaModel extends Model
{
    protected $table = 'kriteria';
    protected $primaryKey = 'id_kriteria';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['id_kriteria', 'kriteria'];
    public $timestamps = false;
}
