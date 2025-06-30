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

        // Cek apakah user sudah login
        if (!$session->has('microsoft_id')) {
            if ($request->isAJAX()) {
                return service('response')->setJSON(['error' => 'Not authenticated'])->setStatusCode(401);
            }
            return redirect()->to(base_url('/login'));
        }

        // Ambil path URL yang diminta
        $path = strtolower(trim(ltrim(strtok($request->getUri()->getPath(), '?'), '/')));

        // Ambil route yang diizinkan dari session
        $allowedRoutes = is_array($session->get('routes')) ? $session->get('routes') : [];

        // Logging untuk debug
        log_message('debug', 'Current path: ' . $path);
        log_message('debug', 'Allowed routes: ' . implode(', ', $allowedRoutes));

        // Cek apakah route diizinkan (pakai str_starts_with untuk handle parameter dinamis)
        $allowed = false;
        foreach ($allowedRoutes as $r) {
            if (str_starts_with($path, strtolower($r))) {
                $allowed = true;
                break;
            }
            log_message('debug', "COMPARE: [$path] starts with [$r] → " . (str_starts_with($path, $r) ? 'YES' : 'NO'));
        }

        if (!$allowed) {
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
