<?php
namespace App\Models;

use CodeIgniter\Model;
class PourcentagePromotionModel extends Model
{
    protected $table = 'pourcentage_promotion';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'promotion'
    ];

    public function getPourcentagePromotion()
    {
        $result = $this->select('pourcentage')
            ->first();
        return $result['pourcentage'] ?? 0;
    }
}
?>