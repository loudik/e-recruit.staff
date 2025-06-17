<?php


namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Beforelogin implements FilterInterface
{
     public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        if (!$session->has('email')) {
            if ($request->isAJAX()) {
                return service('response')->setJSON(['error' => 'Not authenticated'])->setStatusCode(401);
            }
            return redirect()->to(base_url('/login'));
        }
   

        $path = ltrim(strtok($request->getUri()->getPath(), '?'), '/'); // 🔧 bersihkan path

        $routes = $session->get('routes'); 
        $allowedRoutes = $session->get('routes') ?? [];
        $path = strtolower(trim(ltrim(strtok($request->getUri()->getPath(), '?'), '/')));
        foreach ($allowedRoutes as $r) {
            log_message('debug', 'COMPARE: [' . $path . '] == [' . $r . '] → ' . ($path === $r ? 'YES' : 'NO'));
        }


        if (!in_array($path, $allowedRoutes)) {
            if ($request->isAJAX()) {
                return service('response')->setJSON(['error' => 'Access denied'])->setStatusCode(403);
            }

            return redirect()->to(base_url('/admin/dashboard'));
        }

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak digunakan
    }
}
