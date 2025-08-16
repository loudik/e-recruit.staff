<?php


namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Afterlogin implements FilterInterface
{
     public function before(RequestInterface $request, $arguments = null)
    {
        // $session = session();
        // if ($session->has('email')) {
        //   return redirect()->back();
        // }
        if (session()->has('microsoft_id')) {
            
            return redirect()->to('/admin/dashboard'); 
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak digunakan
    }
}
