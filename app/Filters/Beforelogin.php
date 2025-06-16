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
        $allowedRoutes = $routes ? array_map(fn($r) => strtolower(trim($r)), explode(',', $routes)) : [];
        $path = strtolower(trim($path));

        // Debug log
        log_message('debug', 'BEFORELOGIN: PATH = ' . $path);
        log_message('debug', 'BEFORELOGIN: ROUTES = ' . implode(', ', $allowedRoutes));
        log_message('debug', 'MATCH? ' . (in_array($path, $allowedRoutes) ? 'YES' : 'NO'));

        log_message('debug', 'BEFORELOGIN: SESSION email = ' . $session->get('email'));


        foreach ($allowedRoutes as $r) {
            log_message('debug', 'COMPARE: [' . $path . '] == [' . $r . '] → ' . ($path === $r ? 'YES' : 'NO'));
        }


        if (!in_array($path, $allowedRoutes)) {
            if ($request->isAJAX()) {
                return service('response')->setJSON(['error' => 'Access denied'])->setStatusCode(403);
            }

            return redirect()->to(base_url('/admin/dashboard'));
        }


        log_message('debug', 'DEBUGTEST masuk sini tidak 2: ' . $path);

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak digunakan
    }
}
