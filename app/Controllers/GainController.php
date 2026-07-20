<?php
namespace App\Controllers;

    use App\Models\TransactionModel;
    use App\Models\FraisModel;
    use App\Models\TypeOperationModel;
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    class GainController extends BaseController
    {
        public $transactionModel;
        public $fraisModel;
        public $typeOperationModel;

        public function __construct()
        {
            $this->transactionModel = new TransactionModel();
            $this->fraisModel = new FraisModel();
            $this->typeOperationModel = new TypeOperationModel();
        }
        public function index()
        {
            $date = date('Y-m-d H:i:s');
            $totalGains = $this->transactionModel->getSommeTotalGains($date);

            $typeOperations = $this->typeOperationModel->findAll();
            $gainsByTypeOperation = [];

            foreach ($typeOperations as $typeOperation) {
                $gainsByTypeOperation[$typeOperation['nom']] = $this->transactionModel->getSommeTotalGainsByTypeOperation($typeOperation['id'], $date);
            }

            return view('gain/index', [
                'totalGains' => $totalGains,
                'gainsByTypeOperation' => $gainsByTypeOperation
            ]);
        }
    }
?>