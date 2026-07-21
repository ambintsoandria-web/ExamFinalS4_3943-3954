<?php

namespace App\Models;

use CodeIgniter\Model;

class EpargneModel extends Model
{
    protected $table = 'epargne';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'pourcentage',
        'id_client',
    ];
    public function getPourcentage($id_client)
    {
        $result = $this->select('pourcentage')->where('id_client', $id_client)
            ->first();
        return $result['pourcentage'] ?? 0;
    }
}
