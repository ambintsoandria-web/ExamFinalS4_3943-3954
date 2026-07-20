<?php
namespace App\Models;
use CodeIgniter\Model;
class ClientSoldeHistorique extends Model
{
    protected $table = 'client_solde_historique';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'client_id',
        'solde_precedent',
        'date_modification'
    ];

    public function getSoldebyClient($clientId, $date)
    {
        $historique = $this->where('client_id', $clientId)
            ->where('date_modification <', $date)
            ->orderBy('date_modification', 'DESC')
            ->first();
        if (!$historique) {
            $clientModel = new ClientModel();
            $client = $clientModel->find($clientId);
            return $client['solde'];
        }
        return $historique['solde_precedent'];
    }
}
?>