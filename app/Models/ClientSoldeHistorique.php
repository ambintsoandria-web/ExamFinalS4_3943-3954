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
        $clientModel = new ClientModel();
        $client = $clientModel->find($clientId);

        if (!$client) {
            return 0;
        }

        $effectiveDate = $this->normalizeDate($date);

        $historique = $this->where('client_id', $clientId)
            ->where('date_modification <=', $effectiveDate)
            ->orderBy('date_modification', 'DESC')
            ->first();

        if (!$historique) {
            return (float) $client['solde'];
        }

        return (float) $historique['solde_precedent'];
    }

    private function normalizeDate($date): string
    {
        $date = trim((string) ($date ?? ''));

        if ($date === '') {
            return date('Y-m-d H:i:s');
        }

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return $date . ' 23:59:59';
        }

        $dateTime = new \DateTime($date);

        return $dateTime->format('Y-m-d H:i:s');
    }
}
?>