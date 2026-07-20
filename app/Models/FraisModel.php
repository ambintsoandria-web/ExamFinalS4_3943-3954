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
    public function getFraisRetrait($montant)
    {
        return $this->getFraisByTypeOperationAndMontant('retrait', $montant);
    }
    public function getFrais($montant)
    {
        return $this->getFraisByTypeOperationAndMontant('transfert', $montant);
    }

    private function getFraisByTypeOperationAndMontant(string $typeOperationNom, $montant)
    {
        $typeOperation = $this->db->table('types_operations')
            ->select('id')
            ->where('nom', $typeOperationNom)
            ->get()
            ->getRowArray();

        if (! $typeOperation) {
            return 0;
        }

        $montantFrais = 0;
        $listeFrais = $this->where('type_operation_id', $typeOperation['id'])->findAll();
        foreach ($listeFrais as $frais) {
            if ($frais['montant_min'] <= $montant && $montant <= $frais['montant_max']) {
                $montantFrais = $frais['montant_frais'];
            }
        }

        return $montantFrais;
    }
}