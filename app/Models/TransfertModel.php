<?php

namespace App\Models;

use CodeIgniter\Model;

class TransfertModel extends Model
{
    protected $table = 'transferts';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'transaction_id',
        'client_destinataire_id'
    ];

    public function effectuer($clientId, $telephoneDestinataire, $montant)
    {
        $clientModel = new ClientModel();
        $destinataire = $clientModel->where('telephone', $telephoneDestinataire)->first();
        if (!$destinataire) {
            return false;
        }

        $expediteur = $clientModel->find($clientId);
        $frais = (new FraisModel())->getFrais($montant);
        $transactionModel = new TransactionsModel();
        $transactionModel->insert([
            'client_id' => $clientId,
            'type_operation_id' => 3,
            'montant' => $montant,
            'frais' => $frais,
            'date_transaction' => date('Y-m-d H:i:s'),
        ]);

        $this->insert([
            'transaction_id' => $transactionModel->getInsertID(),
            'client_destinataire_id' => $destinataire['id'],
        ]);
        $clientModel->update($clientId, ['solde' => $expediteur['solde'] - ($montant + $frais)]);
        $clientModel->update($destinataire['id'], ['solde' => $destinataire['solde'] + $montant]);
        return true;
    }
}
