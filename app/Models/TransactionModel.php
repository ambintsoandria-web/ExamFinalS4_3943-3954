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
        'date_transaction',
        'frais_commission',
        'id_operateur_recepteur'
    ];
    public function getHistoriqueClient($idClient)
    {
        return $this->join('types_operations', 'transactions.type_operation_id = types_operations.id')
            ->where('transactions.client_id', $idClient)->findAll();
    }

    public function getSommeTotalGains($date)
    {
        return $this->selectSum('frais')
            ->where('date_transaction <', $date)
            ->first();
    }
    public function getSommeTotalGainsByTypeOperation($typeOperationId, $date)
    {
        $result = $this->selectSum('frais')
            ->where('type_operation_id', $typeOperationId)
            ->where('date_transaction <', $date)
            ->first();
        return $result['frais'] ?? 0;
    }
    public function getSoldeTotalByClient($clientId, $date)
    {
        return $this->selectSum('montant + frais as solde_total')
            ->where('client_id', $clientId)
            ->where('date_transaction <', $date)
            ->first();
    }

    public function getStatsClient($clientId)
    {
        return $this->select('types_operations.nom, COUNT(transactions.id) as total, SUM(transactions.montant) as montant')
            ->join('types_operations', 'types_operations.id = transactions.type_operation_id')
            ->where('transactions.client_id', $clientId)
            ->groupBy('types_operations.id')
            ->findAll();
    }

    public function getStatsGlobales()
    {
        return $this->select('types_operations.nom, COUNT(transactions.id) as total, SUM(transactions.montant) as montant')
            ->join('types_operations', 'types_operations.id = transactions.type_operation_id')
            ->groupBy('types_operations.id')
            ->findAll();
    }

    public function getActiviteRecente()
    {
        return $this->select("DATE(date_transaction) as jour, COUNT(id) as total")
            ->groupBy('DATE(date_transaction)')
            ->orderBy('jour', 'DESC')
            ->findAll(7);
    }
    public function getGainsByOperateur($operateur_id, $date)
    {
        return $this->selectSum("frais_commission")
            ->where("id_operateur_recepteur", $operateur_id)
            ->where('date_transaction <', $date)
            ->first();
    }

    public function getSituationOperateurs($operateurConnecte, $date)
    {
        return $this->select('operateurs.nom as operateur_nom, SUM(transactions.frais_commission) as commissions, SUM(transactions.montant + transactions.frais_commission) as montant_a_envoyer, COUNT(transactions.id) as total_transferts')
            ->join('operateurs', 'operateurs.id = transactions.id_operateur_recepteur')
            ->where('transactions.type_operation_id', 3)
            ->where('transactions.id_operateur_recepteur !=', $operateurConnecte)
            ->where('transactions.date_transaction <', $date)
            ->groupBy('operateurs.id')
            ->findAll();
    }

    public function getTotalCommissionsExternes($operateurConnecte, $date)
    {
        $result = $this->selectSum('frais_commission')
            ->where('type_operation_id', 3)
            ->where('id_operateur_recepteur !=', $operateurConnecte)
            ->where('date_transaction <', $date)
            ->first();
        return (float) ($result['frais_commission'] ?? 0);
    }

}
