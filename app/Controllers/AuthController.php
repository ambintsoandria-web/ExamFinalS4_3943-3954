<?php
namespace App\Controllers;

class AuthController extends BaseController
{
    public function logout()
    {
        session()->destroy();
        return redirect()->to(site_url('/'))->with('succes', 'Vous avez ete deconnecte.');
    }
}