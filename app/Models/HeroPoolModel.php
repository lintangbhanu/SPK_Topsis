<?php

namespace App\Models;

use CodeIgniter\Model;

class HeroPoolModel extends Model
{
    protected $table = 'heropool';
    protected $primaryKey = 'id_pool';
    protected $allowedFields = ['id_mlbb', 'hero'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
