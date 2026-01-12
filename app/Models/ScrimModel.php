<?php

namespace App\Models;

use CodeIgniter\Model;

class ScrimModel extends Model
{
    protected $table = 'scrim';
    protected $primaryKey = 'id_scrim';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'id_mlbb',
        'scrim_ke',
        'tanggal',
        'durasi',
        'total_kill',
        'hero_digunakan',
        'jumlah_kill',
        'jumlah_death',
        'jumlah_assist',
        'damage_hero',
        'damage_turret',
        'damage_diterima',
        'jumlah_gold',
        'kontrol_objektif',
        'komunikasi'
    ];

    protected $useTimestamps = true;
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
