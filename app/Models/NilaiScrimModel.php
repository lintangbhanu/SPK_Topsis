<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiScrimModel extends Model
{
    protected $table = 'nilai_scrim';
    protected $primaryKey = 'id_nilai';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'id_scrim',
        'id_kriteria',
        'nilai'
    ];

    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Relations
    protected $joinDatamap = [];
    protected $afterInsert = [];
    protected $afterUpdate = [];
    protected $afterDelete = [];
    protected $afterFind = [];
}
