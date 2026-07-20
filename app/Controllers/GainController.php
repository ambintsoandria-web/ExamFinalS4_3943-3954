<?php
namespace App\Controllers;

    use App\Models\TransactionModel;
    use App\Models\FraisModel;
    use App\Models\TypeOperationModel;
    use App\Models\OperateurModel;
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    class GainController extends BaseController
    {
        public $transactionModel;
        public $fraisModel;
        public $typeOperationModel;
        public $operateurModel;

        public function __construct()
        {
            $this->transactionModel = new TransactionModel();
            $this->fraisModel = new FraisModel();
            $this->typeOperationModel = new TypeOperationModel();
            $this->operateurModel = new OperateurModel();
        }
        public function index()
        {
            $date = date('Y-m-d H:i:s');
            $totalGains = $this->transactionModel->getSommeTotalGains($date);

            $typeOperations = $this->typeOperationModel->findAll();
            $operateurs = $this->operateurModel->findAll();
            $gainsByTypeOperation = [];

            foreach ($typeOperations as $typeOperation) {
                $gainsByTypeOperation[$typeOperation['nom']] = $this->transactionModel->getSommeTotalGainsByTypeOperation($typeOperation['id'], $date);
            }
            $totalGains = 0;
            foreach( $operateurs as $operateur) {
                $gainsByOperateur[$operateur['nom']] = $this->transactionModel->getGainsByOperateur($operateur['id'], $date);
                $totalGains += $gainsByOperateur[$operateur['nom']]['frais_commission'] ?? 0;
            }

            return view('gain/index', [
                'totalGains' => $totalGains,
                'gainsByTypeOperation' => $gainsByTypeOperation,
                'gainsByOperateur' => $gainsByOperateur
            ]);
        }
    }
?>