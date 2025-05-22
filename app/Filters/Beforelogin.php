<?php


namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Beforelogin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // $session = session();
        // if (!$session->has('email')) {
        //   return redirect()->to(base_url(''));
        // }
        if (!session()->has('email')) {
        return redirect()->to(base_url('/login')); // lebih tepat ke '/login'
    }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak digunakan
    }
}
