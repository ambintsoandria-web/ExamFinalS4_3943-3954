<?php
namespace App\Controllers;
error_reporting(E_ALL);
ini_set('display_errors', 1);
use App\Models\FraisModel;
use App\Models\TypeOperationModel;
class FraisController extends BaseController
{
    public $fraisModel;
    public $typeOperationsModel;

    public function __construct()
    {
        $this->fraisModel = new FraisModel();
        $this->typeOperationsModel = new TypeOperationModel();
    }
    public function index()
    {
        $types_operations = $this->typeOperationsModel->findAll();

        $data = [];

        foreach ($types_operations as $type_operation) {
            $frais = $this->fraisModel->getFraisByTypeOperation($type_operation['id']);
            $data[] = [
                'type_operation' => $type_operation,
                'frais' => $frais
            ];
        }
        return view('Frais/index', [
            'data' => $data,
            'title' => 'Gestion des frais',
            'active' => 'frais',
        ]);
    }
    public function create($typeOperationId)
    {
        $typeOperation = $this->typeOperationsModel->find((int) $typeOperationId);
        if (! $typeOperation) {
            return redirect()->to(site_url('operateur/frais'))->with('erreur', "Ce type d'opération n'existe pas.");
        }

        return view('Frais/create', [
            'typeOperationId' => (int) $typeOperationId,
            'typeOperation' => $typeOperation,
            'title' => 'Ajouter un frais',
            'active' => 'frais',
        ]);
    }
    public function add()
    {
        $typeOperationId = (int) $this->request->getPost('type_operation_id');
        $montantMin = filter_var($this->request->getPost('montant_min'), FILTER_VALIDATE_FLOAT);
        $montantMax = filter_var($this->request->getPost('montant_max'), FILTER_VALIDATE_FLOAT);
        $montantFrais = filter_var($this->request->getPost('montant_frais'), FILTER_VALIDATE_FLOAT);

        if (! $this->typeOperationsModel->find($typeOperationId)) {
            return redirect()->to(site_url('operateur/frais'))->with('erreur', "Le type d'opération est invalide.");
        }
        if ($montantMin === false || $montantMax === false || $montantFrais === false
            || $montantMin < 0 || $montantMax <= $montantMin || $montantFrais < 0) {
            return redirect()->back()->withInput()->with('erreur', 'Vérifiez les montants : le maximum doit être supérieur au minimum.');
        }

        $data = [
            'type_operation_id' => $typeOperationId,
            'montant_min' => $montantMin,
            'montant_max' => $montantMax,
            'montant_frais' => $montantFrais
        ];

        if (! $this->fraisModel->insert($data)) {
            return redirect()->back()->withInput()->with('erreur', "Impossible d'enregistrer ce barème.");
        }

        return redirect()->to(site_url('operateur/frais'))->with('succes', 'Le barème de frais a été ajouté.');
    }
    public function edit($fraisId)
    {
        $frais = $this->fraisModel->getFraisById($fraisId);
        return view('Frais/modify', ['frais' => $frais]);
    }
    public function update($fraisId)
    {
        $montantMin = $this->request->getPost('montant_min');
        $montantMax = $this->request->getPost('montant_max');
        $montantFrais = $this->request->getPost('montant_frais');

        $data = [
            'montant_min' => $montantMin,
            'montant_max' => $montantMax,
            'montant_frais' => $montantFrais
        ];

        $this->fraisModel->updateFrais($fraisId, $data);

        return redirect()->to(site_url('operateur/frais'));
    }
    public function delete($fraisId)
    {
        $this->fraisModel->deleteFrais($fraisId);
        return redirect()->to(site_url('operateur/frais'));
    }
}
