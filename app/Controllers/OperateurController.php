<?php
namespace App\Controllers;
use App\Models\ComissionsModel;
use App\Models\OperateurModel;
use App\Models\PrefixeModel;
use App\Models\TransactionModel;
use App\Models\ClientModel;

error_reporting(E_ALL);
ini_set('display_errors', 1);

class OperateurController extends BaseController
{
    private OperateurModel $operateurModel;
    protected PrefixeModel $prefixeModel;
    protected ComissionsModel $commissionModel;

    public function __construct()
    {
        $this->operateurModel = new OperateurModel();
        $this->prefixeModel = new PrefixeModel();
        $this->commissionModel = new ComissionsModel();
    }
    public function goToSituationOperateur()
    {
        $idOperateur = (int) session('auth_id');
        $listeOperateurs = $this->operateurModel->getAutresOperateurs($idOperateur);
        foreach ($listeOperateurs as &$operateur) {
            $operateur['situation'] = $this->operateurModel->getGainsByOperateur($operateur['id']);
        }
        $data = [
            'listeOperateurs' => $listeOperateurs,
            'title' => 'Situation des autres opérateurs',
            'active' => 'situation-operateurs',
        ];
        return view('Operateur/situationOperateur', $data);
    }
    public function deleteComission($idComission)
    {
        $this->commissionModel->delete($idComission);
        return redirect()->to(site_url('operateur/comissions'))
            ->with('succes', 'Commission supprimée avec succès.');
    }
    public function addComission()
    {
        $id_operateur = $this->request->getPost('id_operateur');
        $pct_commission = $this->request->getPost('pct_commission');

        if ((int) $id_operateur === (int) session('auth_id')) {
            return redirect()->to(site_url('operateur/comissions'))
                ->with('erreur', 'Vous ne pouvez pas définir votre propre commission.');
        }

        $existing = $this->commissionModel->existePourOperateur($id_operateur);
        if ($existing) {
            return redirect()->to(site_url('operateur/comissions'))
                ->with('erreur', 'Cet opérateur a déjà une commission.');
        }

        $data = [
            'id_operateur' => $id_operateur,
            'pct_commission' => $pct_commission
        ];

        $this->commissionModel->save($data);

        return redirect()->to(site_url('operateur/comissions'))
            ->with('succes', 'Commission ajoutée avec succès.');
    }
    public function goToComissions()
    {
        $data['operateurs'] = $this->operateurModel->getAutresOperateurs(session('auth_id'));
        $data['commissions'] = $this->commissionModel->getAvecOperateur();
        $data['title'] = 'Gestion des commissions';
        $data['active'] = 'commissions';

        return view('Operateur/comissions', $data);
    }
    public function goToPrefixe()
    {
        $data['operateurs'] = $this->operateurModel->findAll();
        $data['listePrefixe'] = $this->prefixeModel->getAvecOperateur();
        $data['title'] = 'Gestion des préfixes';
        $data['active'] = 'prefixes';
        return view('Operateur/prefixe', $data);
    }

    public function addPrefixe()
    {
        $prefix = trim((string) $this->request->getPost('prefix'));
        $operateurId = $this->request->getPost('operateur_id');
        if (!preg_match('/^0[0-9]{2}$/', $prefix)) {
            return redirect()->back()->withInput()->with('erreur', 'Le préfixe doit contenir 3 chiffres et commencer par 0.');
        }

        $prefixeModel = new PrefixeModel();
        if ($prefixeModel->where('prefix', $prefix)->first()) {
            return redirect()->back()->withInput()->with('erreur', 'Ce préfixe existe déjà.');
        }

        $prefixeModel->insert([
            'prefix' => $prefix,
            'id_operateur' => $operateurId,
        ]);
        return redirect()->to(site_url('operateur/prefixes'))->with('succes', 'Le préfixe ' . $prefix . ' a été ajouté.');
    }

    public function deletePrefixe($id)
    {
        $this->prefixeModel->delete($id);
        return redirect()->to(site_url('operateur/prefixes'))->with('succes', 'Préfixe supprimé avec succès.');
    }
    public function login()
    {
        if (session('auth_type') === 'operateur') {
            return redirect()->to(site_url('operateur/espace'));
        }
        return view('Operateur/loginOperateur');
    }

    public function authenticate()
    {
        $identifiant = trim((string) $this->request->getPost('identifiant'));
        $password = (string) $this->request->getPost('mot_de_passe');
        if ($identifiant === '' || $password === '') {
            return redirect()->back()->withInput()->with('erreur', 'Renseignez votre identifiant et votre mot de passe.');
        }
        $operateur = $this->operateurModel->authenticate($identifiant, $password);
        if (!$operateur) {
            return redirect()->back()->withInput()->with('erreur', 'Identifiants incorrects ou compte desactive.');
        }
        session()->regenerate();
        session()->set([
            'auth_id' => (int) $operateur['id'],
            'auth_type' => 'operateur',
            'auth_nom' => $operateur['nom'],
            'auth_telephone' => $operateur['telephone'],
            'logged_in' => true,
        ]);
        return redirect()->to(site_url('operateur/goToprefixe'))->with('succes', 'Connexion operateur reussie.');
    }

    public function dashboard()
    {
        $operateur = $this->operateurModel->find((int) session('auth_id'));
        if (!$operateur || (int) $operateur['actif'] !== 1) {
            session()->destroy();
            return redirect()->to(site_url('connexion/operateur'))->with('erreur', 'Votre compte operateur est indisponible.');
        }
        return view('Operateur/dashboard', [
            'operateur' => $operateur,
            'stats' => (new TransactionModel())->getStatsGlobales(),
            'activite' => array_reverse((new TransactionModel())->getActiviteRecente()),
            'nombreClients' => (new ClientModel())->getNombreClientsActifs(),
            'title' => 'Tableau de bord opérateur',
            'active' => 'dashboard',
        ]);
    }
}
