<?php

namespace App\Models;

use CodeIgniter\Model;

class PrefixeModel extends Model
{
    protected $table = 'prefixes';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'prefix',
        'id_operateur'
    ];
    public function isNumeroValide($numero)
    {
        if (strlen($numero) !== 10) {
            return false;
        }

        $prefixes = $this->findAll();

        foreach ($prefixes as $prefixe) {
            if (strpos($numero, $prefixe['prefix']) === 0) {
                return true;
            }
        }

        return false;
    }

    public function getAvecOperateur()
    {
        return $this->select('prefixes.*, operateurs.nom as operateur_nom')
            ->join('operateurs', 'operateurs.id = prefixes.id_operateur')
            ->findAll();
    }
}
