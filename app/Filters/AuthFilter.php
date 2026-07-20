<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        if (! $session->get('auth_id') || ! in_array($session->get('auth_type'), ['client', 'operateur'], true)) {
            return redirect()->to(site_url('/'))->with('erreur', 'Connectez-vous pour acceder a cette page.');
        }
    }
    public function after(
        RequestInterface $request,
        ResponseInterface
        $response,
        $arguments = null
    ) {

    }
}
?>
