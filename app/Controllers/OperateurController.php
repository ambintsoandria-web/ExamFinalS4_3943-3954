<?php
namespace App\Controllers;
use App\Models\OperateurModel;
use App\Models\PrefixeModel;

error_reporting(E_ALL);
ini_set('display_errors', 1);

class OperateurController extends BaseController
{
    private OperateurModel $operateurModel;
    protected PrefixeModel $prefixeModel;
    public function __construct()
    {
        $this->operateurModel = new OperateurModel();
        $this->prefixeModel = new PrefixeModel();
    }
    public function goToPrefixe()
    {
        $data['listePrefixe'] = $this->prefixeModel->findAll();
        $data['title'] = 'Gestion des préfixes';
        $data['active'] = 'prefixes';
        return view('Operateur/prefixe', $data);
    }

    public function addPrefixe()
    {
        $prefix = trim((string) $this->request->getPost('prefix'));
        if (!preg_match('/^0[0-9]{2}$/', $prefix)) {
            return redirect()->back()->withInput()->with('erreur', 'Le préfixe doit contenir 3 chiffres et commencer par 0.');
        }

        $prefixeModel = new PrefixeModel();
        if ($prefixeModel->where('prefix', $prefix)->first()) {
            return redirect()->back()->withInput()->with('erreur', 'Ce préfixe existe déjà.');
        }

        $prefixeModel->insert(['prefix' => $prefix]);
        return redirect()->to(site_url('operateur/prefixes'))->with('succes', 'Le préfixe ' . $prefix . ' a été ajouté.');
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
            'title' => 'Tableau de bord opérateur',
            'active' => 'dashboard',
        ]);
    }
}
