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

    public function effectuer($clientId, $telephoneDestinataire, $montant, $ajouterFraisRetrait = false)
    {
        $clientModel = new ClientModel();
        $destinataire = $clientModel->where('telephone', $telephoneDestinataire)->first();
        if (!$destinataire) {
            return false;
        }

        $expediteur = $clientModel->find($clientId);
        $frais = (new FraisModel())->getFrais($montant);
        $prefixeModel = new PrefixeModel();
        $operateurExpediteur = $prefixeModel->getOperateurParNumero($expediteur['telephone']);
        $operateurRecepteur = $prefixeModel->getOperateurParNumero($destinataire['telephone']);
        if (!$operateurRecepteur) {
            return false;
        }

        $fraisCommission = 0;
        if ($operateurRecepteur !== $operateurExpediteur) {
            $pourcentage = (new ComissionsModel())->getPourcentage($operateurRecepteur);
            $fraisCommission = round($montant * $pourcentage / 100, 2);
        }

        $fraisRetrait = 0;
        if($ajouterFraisRetrait) {
            $fraisRetrait = (new FraisModel())->getFraisRetrait($montant);
        }

        $montantTotal = $montant + $frais + $fraisCommission + $fraisRetrait;

        $transactionModel = new TransactionModel();
        $transactionModel->insert([
            'client_id' => $clientId,
            'type_operation_id' => 3,
            'montant' => $montant + $fraisRetrait,
            'frais' => $frais,
            'frais_commission' => $fraisCommission,
            'id_operateur_recepteur' => $operateurRecepteur,
            'date_transaction' => date('Y-m-d H:i:s'),
        ]);

        $this->insert([
            'transaction_id' => $transactionModel->getInsertID(),
            'client_destinataire_id' => $destinataire['id'],
        ]);
        $clientModel->update($clientId, ['solde' => $expediteur['solde'] - $montantTotal]);
        $clientModel->update($destinataire['id'], ['solde' => $destinataire['solde'] + $montant]);
        return true;
    }
}
