<?php

namespace App\Models;

use CodeIgniter\Model;

class OperateurModel extends Model
{
    protected $table = 'operateurs';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'email',
        'telephone',
        'nom',
        'mot_de_passe',
        'actif',
        'date_creation'
    ];
    public function authenticate(string $identifiant, string $password): array|false
    {
        $identifiant = strtolower(trim($identifiant));
        $builder = $this->where('actif', 1)->groupStart();
        if ($this->db->fieldExists('email', $this->table)) {
            $builder->where('LOWER(email)', $identifiant);
            if (!str_contains($identifiant, '@')) {
                $builder->orWhere('telephone', preg_replace('/\s+/', '', $identifiant));
            }
        } else {
            $builder->where('telephone', preg_replace('/\s+/', '', $identifiant));
        }
        $user = $builder->groupEnd()->first();

        if (!$user) {
            return false;
        }

        $storedPassword = (string) $user['mot_de_passe'];
        $valid = password_verify($password, $storedPassword)
            || hash_equals($storedPassword, $password);

        return $valid ? $user : false;
    }

    public function getAutresOperateurs($operateurId)
    {
        return $this->where('id !=', $operateurId)->where('actif', 1)->findAll();
    }

    public function getSituationOperateurs($operateurId)
    {
        return $this->select('operateurs.id, operateurs.nom, operateurs.telephone, COUNT(transactions.id) as total_transferts, COALESCE(SUM(transactions.montant), 0) as montant_transfere, COALESCE(SUM(transactions.frais_commission), 0) as commissions, COALESCE(SUM(transactions.montant + transactions.frais_commission), 0) as total_a_envoyer')
            ->join('transactions', 'transactions.id_operateur_recepteur = operateurs.id AND transactions.type_operation_id = 3', 'left')
            ->where('operateurs.id !=', $operateurId)
            ->where('operateurs.actif', 1)
            ->groupBy('operateurs.id')->findAll();
    }

    public function getGainsByOperateur($operateurId)
    {
        $resultat = $this->db->table('transactions')
            ->selectSum('frais_commission', 'total_commission')
            ->where('type_operation_id', 3)
            ->where('id_operateur_recepteur', $operateurId)
            ->get()->getRowArray();

        return (float) ($resultat['total_commission'] ?? 0);
    }
}
