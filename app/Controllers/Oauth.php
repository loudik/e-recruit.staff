<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use TheNetworg\OAuth2\Client\Provider\Azure;

class Oauth extends Controller
{
    protected $provider;

    public function __construct()
    {
        $this->provider = new Azure([
            'clientId'     => getenv('AZURE_CLIENT_ID'),
            'clientSecret' => getenv('AZURE_CLIENT_SECRET'),
            'redirectUri'  => getenv('AZURE_REDIRECT_URI'),
            'tenant'       => getenv('AZURE_TENANT_ID'),
            'urlAuthorize' => 'https://login.microsoftonline.com/' . getenv('AZURE_TENANT_ID') . '/oauth2/v2.0/authorize',
            'urlAccessToken' => 'https://login.microsoftonline.com/' . getenv('AZURE_TENANT_ID') . '/oauth2/v2.0/token',
            'scopes'       => ['openid', 'profile', 'email', 'offline_access', 'User.Read'],
        ]);

        $this->provider->defaultEndPointVersion = '2.0';
    }

    public function index()
    {
        echo '<a href="' . base_url('auth/login') . '">Login with Microsoft</a>';
    }

    public function login()
    {
        $email = $this->request->getGet('email'); // dari form input, bisa kosong

        $options = [
            'prompt' => 'select_account'
        ];

        // Jika user submit email dari form, tambahkan login_hint
        if ($email) {
            $options['login_hint'] = $email;
        }

        $authUrl = $this->provider->getAuthorizationUrl($options);
        session()->set('oauth2state', $this->provider->getState());

        return redirect()->to($authUrl);
    }


   public function callback()
    {
        $sessionState = session()->get('oauth2state');
        $requestState = $this->request->getVar('state');

        if (!$requestState || $requestState !== $sessionState) {
            session()->remove('oauth2state');
            exit('Invalid state');
        }

        try {
            // Ambil token dari Microsoft
            $token = $this->provider->getAccessToken('authorization_code', [
                'code' => $this->request->getVar('code')
            ]);


            $accessToken   = $token->getToken();
            $client        = \Config\Services::curlrequest();
            $defaultAvatar = base_url('assets/images/customer-4.png');

            // Ambil data user dari Graph
            $graphResponse = $client->get('https://graph.microsoft.com/v1.0/me', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken
                ]
            ]);
            $userGraph = json_decode($graphResponse->getBody(), true);

            // var_dump($userGraph);return;

            // $email    = strtolower($userGraph['mail'] ?? $userGraph['userPrincipalName'] ?? '');
            // $name     = $userGraph['displayName'] ?? $email;
            // $jobTitle = $userGraph['jobTitle'] ?? 'Tidak tersedia';

            // if (!$email) {
            //     exit('Gagal login: Email tidak ditemukan.');
            // }

            // Ambil foto profil, fallback jika 404/error
            try {
                $photoResponse = $client->get('https://graph.microsoft.com/v1.0/me/photo/$value', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken
                    ],
                    'stream' => true
                ]);

                $base64Image = ($photoResponse->getStatusCode() === 200)
                    ? 'data:image/jpeg;base64,' . base64_encode($photoResponse->getBody())
                    : $defaultAvatar;
            } catch (\Exception $e) {
                $base64Image = $defaultAvatar;
            }

            // Simpan session
            session()->set([
                'phone'       => $userGraph['businessPhones'],
                'name'    => $userGraph['displayName'],
                'jobtitle'    => $userGraph['jobTitle'],
                'email'    => $userGraph['userPrincipalName'],
                'avatar'      => $base64Image,
                'isLoggedIn'  => true,
            ]);

            return redirect()->to('/admin/dashboard');

        } catch (\Exception $e) {
            exit('Gagal login: ' . $e->getMessage());
        }
    }

    public function fn_loginform()
    {
        $email = $this->request->getPost('email') ?? $this->request->getGet('email');

        // Jika dari form (POST), cek ke DB dulu
        if ($this->request->getMethod() === 'post') {
            if (!$email) {
                return redirect()->back()->with('error', 'Email wajib diisi.');
            }

            $db = \Config\Database::connect();
            $user = $db->table('tbl_login')
                ->where('username', $email)
                ->where('isdeleted', 0)
                ->get()
                ->getRow();

            if (!$user) {
                return redirect()->back()->with('error', 'Email tidak terdaftar.');
            }
        }

        // Buat URL login Microsoft
        $options = [
            'prompt' => 'select_account'
        ];

        if ($email) {
            $options['login_hint'] = $email;
        }

        $authUrl = $this->provider->getAuthorizationUrl($options);
        session()->set('oauth2state', $this->provider->getState());

        return redirect()->to($authUrl);
    }






    

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
