<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'telephone',
        'nom',
        'solde',
        'actif',
        'date_creation'
    ];
    public function login_auto(string $telephone): array|false
    {
        $prefixeModel = new PrefixeModel();
        if (!$prefixeModel->isNumeroValide($telephone)) {
            return false;
        }

        $client = $this->where('telephone', $telephone)->where('actif', 1)->first();

        if (!$client) {
            return false;
        }

        return $client;
    }

    public function getSituationClients($date)
    {
        $clients = $this->findAll();
        $historiqueModel = new ClientSoldeHistorique();
        foreach ($clients as &$client) {
            $client['solde'] = $historiqueModel->getSoldebyClient($client['id'], $date . ' 23:59:59');
        }
        return $clients;
    }

    public function getNombreClientsActifs()
    {
        return $this->where('actif', 1)->countAllResults();
    }
}
