<?php

namespace App\Models;

use CodeIgniter\Model;

class ComissionsModel extends Model
{
    protected $table = 'commisions';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'id_operateur',
        'pct_commission'
    ];

    public function getAvecOperateur()
    {
        return $this->select('commisions.*, operateurs.nom as operateur_nom')
            ->join('operateurs', 'operateurs.id = commisions.id_operateur')
            ->findAll();
    }

    public function existePourOperateur($operateurId)
    {
        return $this->where('id_operateur', $operateurId)->first();
    }
}
