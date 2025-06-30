<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\Md_adminpanel;

class HomeAccess implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if ($session->get('logged_in')) {
            return;
        }

        $email = $request->getGet('email');

        if (!$email) {
            return redirect()->to(base_url('loginpage'));
        }

        $model = new Md_adminpanel();
        $data = $model->getCategoryByEmailFromJob($email);

        if (!$data || !isset($data['category'])) {
            return redirect()->to(base_url('loginpage'));
        }

        if (strtolower($data['category']) === 'internship') {
            return; // allow
        }

        return redirect()->to(base_url('loginpage'));
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Kosongkan jika tidak ada logic after
    }
}
