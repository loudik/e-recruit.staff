<?php

namespace App\Controllers;
use App\Models\Md_login;
use Google\Client as GoogleClient;

class Login extends BaseController
{
    public function __construct()
    {
        $this->Md_login = new Md_login();
    }
    public function fn_getlogin()
    {         
      $title = 'Page Login';
      return view('login/vw_login', ['title' => $title]);
    }

    public function fn_getgoogle()
    {
        $config = config('GoogleOAuth');

        $client = new GoogleClient();
        $client->setClientId($config->clientId);
        $client->setClientSecret($config->clientSecret);
        $client->setRedirectUri($config->redirectUri);
        $client->setScopes($config->scopes);

        return redirect()->to($client->createAuthUrl());
    }

    



    public function fn_login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Validasi input kosong
        if (empty($username) || empty($password)) {
            return $this->response->setJSON([
                'response' => 'error',
                'message'  => 'Username and password are required!',
            ]);
        }
        
        // Ambil user dari database via model
        $user = $this->Md_login->getUserByUsername($username);

        if (!$user || $user['isdeleted'] == 1) {
            return $this->response->setJSON([
                'response' => 'error',
                'message'  => 'User not found or inactive!',
            ]);
        }

        // Verifikasi password hash
        if (!password_verify($password, $user['password_hash'])) {
            return $this->response->setJSON([
                'response' => 'error',
                'message'  => 'Incorrect password!',
            ]);
        }

        // Set session jika login berhasil
        session()->set([
            'user_id'   => $user['id'],
            'username'  => $user['username'],
            'logged_in' => true,
        ]);

        return $this->response->setJSON([
            'response' => 'success',
            'message'  => 'Login successful!',
        ]);
    }

    
    public function check()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Validasi login (cek di database)
        $user = $this->db->table('users')->where('username', $username)->get()->getRow();

        if ($user && password_verify($password, $user->password)) {
            session()->set(['logged_in' => true, 'username' => $username]);
            return redirect()->to('/dashboard');
        } else {
            return redirect()->back()->with('error', 'Invalid credentials');
        }
    }


 

  }