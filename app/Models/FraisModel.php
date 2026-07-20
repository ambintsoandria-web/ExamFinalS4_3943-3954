<?php

namespace App\Models;

use CodeIgniter\Model;

class FraisModel extends Model
{
    protected $table = 'frais';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'type_operation_id',
        'montant_min',
        'montant_max',
        'montant_frais'
    ];

    public function getFraisByTypeOperation($typeOperationId)
    {
        return $this->where('type_operation_id', $typeOperationId)->findAll();
    }
    public function deleteFrais($fraisId)
    {
        return $this->delete($fraisId);
    }
    public function updateFrais($fraisId, $data)
    {
        return $this->update($fraisId, $data);
    }
    public function getFraisById($fraisId)
    {
        return $this->find($fraisId);
    }
    public function getFrais($montant)
    {
        $montantFrais = 0;
        $listeFrais = $this->findAll();
        foreach ($listeFrais as $frais) {
            if ($frais['montant_min'] <= $montant && $montant <= $frais['montant_max']) {
                $montantFrais = $frais['montant_frais'];
            }
        }
        return $montantFrais;
    }
}