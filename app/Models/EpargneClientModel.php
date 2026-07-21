<?php

namespace App\Models;

use CodeIgniter\Model;

class EpargneClientModel extends Model
{
    protected $table = 'epargne_client';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'client_id',
        'montant',
    ];
}
