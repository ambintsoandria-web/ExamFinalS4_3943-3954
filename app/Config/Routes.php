<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'ClientController::login');
$routes->get('connexion', 'ClientController::login');
$routes->post('connexion/client', 'ClientController::authenticate');
$routes->get('connexion/operateur', 'OperateurController::login');

$routes->post('connexion/operateur', 'OperateurController::authenticate'); //post
$routes->post('deconnexion', 'AuthController::logout', ['filter' => 'auth']);

$routes->get('client/espace', 'ClientController::dashboard', ['filter' => 'clientAuth']);
$routes->get('client/retrait', 'ClientController::goToRetrait', ['filter' => 'clientAuth']);
$routes->get('client/depot', 'ClientController::goToDepot', ['filter' => 'clientAuth']);
$routes->post('client/depot', 'ClientController::addDepot', ['filter' => 'clientAuth']);
$routes->post('client/retrait', 'ClientController::addRetrait', ['filter' => 'clientAuth']);
$routes->get('client/transfert', 'ClientController::goToTransfert', ['filter' => 'clientAuth']);
$routes->get('client/historique', 'ClientController::goToHistorique', ['filter' => 'clientAuth']);
$routes->post('client/transfert', 'ClientController::addTransfert', ['filter' => 'clientAuth']);


$routes->get('operateur/espace', 'OperateurController::dashboard', ['filter' => 'operateurAuth']);

$routes->get('operateur/goToprefixe', 'OperateurController::goToPrefixe', ['filter' => 'operateurAuth']);
$routes->get('operateur/prefixes', 'OperateurController::goToPrefixe', ['filter' => 'operateurAuth']);
$routes->post('operateur/prefixes/add', 'OperateurController::addPrefixe', ['filter' => 'operateurAuth']);
$routes->get('operateur/frais', 'FraisController::index', ['filter' => 'operateurAuth']);
$routes->get('operateur/frais/create/(:num)', 'FraisController::create/$1', ['filter' => 'operateurAuth']);
$routes->post('frais/add', 'FraisController::add', ['filter' => 'operateurAuth']);
$routes->get('frais/edit/(:num)', 'FraisController::edit/$1', ['filter' => 'operateurAuth']);
$routes->post('frais/update/(:num)', 'FraisController::update/$1', ['filter' => 'operateurAuth']);
$routes->get('frais/delete/(:num)', 'FraisController::delete/$1', ['filter' => 'operateurAuth']);
$routes->get('operateur/gains', 'GainController::index', ['filter' => 'operateurAuth']);
$routes->get('operateur/clients', 'ClientController::getSituationClients', ['filter' => 'operateurAuth']);
$routes->get('operateur/client', 'ClientController::getSituationClients', ['filter' => 'operateurAuth']);
$routes->get('operateur/situation', 'ClientController::getSituationClients', ['filter' => 'operateurAuth']);
