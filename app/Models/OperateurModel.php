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
}
