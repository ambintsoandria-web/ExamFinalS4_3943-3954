<?php

namespace App\Controllers;

error_reporting(E_ALL);
ini_set('display_errors', 1);



use App\Models\ClientModel;
use App\Models\FraisModel;
use App\Models\TransfertModel;

use App\Models\TransactionModel;
use App\Models\ClientSoldeHistorique;


class ClientController extends BaseController
{
    protected ClientModel $clientModel;
    protected TransactionModel $transactionsModel;
    protected FraisModel $fraisModel;
    protected TransfertModel $transfertModel;
    public TransactionModel $transactionModel;
    public ClientSoldeHistorique $clientSoldeHistorique;


    public function __construct()
    {
        $this->clientModel = new ClientModel();
        $this->transactionsModel = new TransactionModel();
        $this->fraisModel = new FraisModel();
        $this->transfertModel = new TransfertModel();
        $this->transactionModel = new TransactionModel();
        $this->clientSoldeHistorique = new ClientSoldeHistorique();
    }
    public function goToHistorique()
    {
        $clientId = session('auth_id');
        $client = $this->clientModel->find($clientId);
        $data['listeHistorique'] = $this->transactionsModel->getHistoriqueClient($client['id']);
        $data['title'] = 'Voir historique';
        $data['active'] = 'historique';
        return view('Client/historique', $data);
    }
    public function goToRetrait()
    {
        return view('Client/retrait', ['title' => 'Faire un retrait', 'active' => 'retrait']);
    }
    public function addDepot()
    {
        $montant = $this->request->getPost('montant');
        $clientId = session('auth_id');
        $client = $this->clientModel->find($clientId);
        $this->clientSoldeHistorique->insert([
            'client_id' => $client['id'],
            'solde_precedent' => $client['solde'],
            'date_modification' => date('Y-m-d H:i:s'),
        ]);

        $this->transactionsModel->insert([
            'client_id' => $clientId,
            'type_operation_id' => 1,
            'montant' => $montant,
            'frais' => 0,
            'date_transaction' => date('Y-m-d H:i:s'),
        ]);

        $this->clientModel->update($clientId, [
            'solde' => $client['solde'] + $montant,
        ]);

        return redirect()->to(site_url('client/espace'))->with('succes', 'Dépôt enregistré avec succès.');
    }
    public function addRetrait()
    {
        $montant = $this->request->getPost('montant');
        $clientId = session('auth_id');
        $client = $this->clientModel->find($clientId);
        $this->clientSoldeHistorique->insert([
            'client_id' => $client['id'],
            'solde_precedent' => $client['solde'],
            'date_modification' => date('Y-m-d H:i:s'),
        ]);


        $this->transactionsModel->insert([
            'client_id' => $clientId,
            'type_operation_id' => 2,
            'montant' => $montant,
            'frais' => $this->fraisModel->getFrais($montant),
            'date_transaction' => date('Y-m-d H:i:s'),
        ]);

        $this->clientModel->update($clientId, [
            'solde' => $client['solde'] - ($montant + $this->fraisModel->getFrais($montant)),
        ]);
        return redirect()->to(site_url('client/espace'))->with('succes', 'Retrait enregistré avec succès.');
    }
    public function addTransfert()
    {
        $montant = $this->request->getPost('montant');
        $telephone = $this->request->getPost('telephone');
        $clientId = session('auth_id');
        $client = $this->clientModel->find($clientId);
        $this->clientSoldeHistorique->insert([
            'client_id' => $client['id'],
            'solde_precedent' => $client['solde'],
            'date_modification' => date('Y-m-d H:i:s'),
        ]);

        if (!$this->transfertModel->effectuer(session('auth_id'), $telephone, $montant)) {
            return redirect()->back()->withInput()->with('erreur', 'Client inexistant.');
        }
        return redirect()->to(site_url('client/espace'))->with('succes', 'Transfert enregistré avec succès.');
    }

    public function goToTransfert()
    {
        return view('Client/transfert', ['title' => 'Faire un transfert', 'active' => 'transfert']);
    }

    public function login()
    {
        if (session('auth_type') === 'client') {
            return redirect()->to(site_url('client/espace'));
        }
        if (session('auth_type') === 'operateur') {
            return redirect()->to(site_url('operateur/espace'));
        }
        return view('Client/loginClient');
    }
    public function goToDepot()
    {
        return view('Client/depot', ['title' => 'Faire un dépôt', 'active' => 'depot']);
    }

    public function authenticate()
    {
        $telephone = preg_replace('/\s+/', '', (string) $this->request->getPost('telephone'));
        if (!preg_match('/^0[0-9]{9}$/', $telephone)) {
            return redirect()->back()->withInput()->with('erreur', 'Saisissez un numero valide de 10 chiffres.');
        }
        $client = $this->clientModel->login_auto($telephone);
        if (!$client) {
            return redirect()->back()->withInput()->with('erreur', 'Ce numero ne correspond a aucun client actif.');
        }
        session()->regenerate();
        session()->set([
            'auth_id' => (int) $client['id'],
            'auth_type' => 'client',
            'auth_nom' => $client['nom'],
            'auth_telephone' => $client['telephone'],
            'logged_in' => true,
        ]);
        return redirect()->to(site_url('client/espace'))->with('succes', 'Bienvenue ' . $client['nom'] . ' !');
    }

    public function dashboard()
    {
        $client = $this->clientModel->find((int) session('auth_id'));
        if (!$client || (int) $client['actif'] !== 1) {
            session()->destroy();
            return redirect()->to(site_url('/'))->with('erreur', 'Votre compte client est indisponible.');
        }
        return view('Client/dashboard', [
            'client' => $client,
            'title' => 'Mon espace client',
            'active' => 'dashboard',
        ]);
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to(site_url('/'))->with('succes', 'Vous avez été déconnecté avec succès.');
    }
    public function getSituationClients()
    {
        $clients = $this->clientModel->findAll();
        $date = date('Y-m-d H:i:s');
        foreach ($clients as &$client) {
            $client['solde'] = $this->clientSoldeHistorique->getSoldebyClient($client['id'], $date);
        }
        return view('Client/situation', ['clients' => $clients]);
    }
}
