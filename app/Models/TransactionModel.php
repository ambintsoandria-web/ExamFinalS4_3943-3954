<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'client_id',
        'type_operation_id',
        'montant',
        'frais',
        'date_transaction'
    ];
    public function getHistoriqueClient($idClient)
    {
        return $this->join('types_operations', 'transactions.type_operation_id = types_operations.id')
            ->where('transactions.client_id', $idClient)->findAll();
    }


    public function getSommeTotalGains($date){
        return $this->selectSum('frais')
            ->where('date_transaction <', $date)
            ->first();
    }
    public function getSommeTotalGainsByTypeOperation($typeOperationId, $date){
        $result =  $this->selectSum('frais')
            ->where('type_operation_id', $typeOperationId)
            ->where('date_transaction <', $date)
            ->first();
        return $result['frais'] ?? 0;
    }
    public function getSoldeTotalByClient($clientId, $date){
        return $this->selectSum('montant + frais as solde_total')
            ->where('client_id', $clientId)
            ->where('date_transaction <', $date)
            ->first();
    }

}
