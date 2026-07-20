<?php

namespace App\Models;

use CodeIgniter\Model;

class PrefixeModel extends Model
{
    protected $table = 'prefixes';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'prefix'
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
}

