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

        // Redirect jika belum login
        if (!$session->has('email')) {
            return redirect()->to(base_url('/login'));
        }

        $path = $request->getUri()->getPath();
        $routes = $session->get('routes'); 
        $allowedRoutes = $routes ? array_map('trim', explode(',', $routes)) : [];

        log_message('debug', 'DEBUGTEST Path accessed: ' . $path);
        log_message('debug', 'DEBUGTEST Allowed routes: ' . implode(', ', $allowedRoutes));

        if (!in_array($path, $allowedRoutes)) {
            log_message('debug', 'DEBUGTEST masuk sini tidak 1: ' . $path);
            return redirect()->to(base_url('/admin/dashboard')); // ✅ return!
        }

        log_message('debug', 'DEBUGTEST masuk sini tidak 2: ' . $path);

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak digunakan
    }
}
