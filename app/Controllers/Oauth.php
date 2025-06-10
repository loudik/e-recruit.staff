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
            'scopes'       => ['openid', 'profile', 'email', 'offline_access', 'User.Read', 'User.Read.All'],
        ]);

        $this->provider->defaultEndPointVersion = '2.0';
    }

    public function index()
    {
        echo '<a href="' . base_url('auth/login') . '">Login with Microsoft</a>';
    }

    public function login()
    {
        $email = $this->request->getGet('email'); 
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
            // $token = $this->provider->getAccessToken('authorization_code', [
            //     'code' => $this->request->getVar('code')
            // ]);


            // $accessToken   = $token->getToken();

            $token = $this->provider->getAccessToken('authorization_code', [
                'code' => $this->request->getVar('code')
            ]);

            $accessToken = $token->getToken();
            $refreshToken = $token->getRefreshToken();

            // ✅ Simpan token ke session
            session()->set('microsoft_token', $accessToken);
            session()->set('microsoft_refresh_token', $refreshToken);

            log_message('debug', 'Session Token: ' . session()->get('microsoft_token'));


            $client        = \Config\Services::curlrequest();
            $defaultAvatar = base_url('assets/images/customer-4.png');

            // Ambil data user dari Graph
            $graphResponse = $client->get('https://graph.microsoft.com/v1.0/me', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken
                ]
            ]);
            $userGraph = json_decode($graphResponse->getBody(), true);
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

   

    public function fetchAzureUsers()
{
    $token = session()->get('microsoft_token');
    if (!$token) {
        return $this->response->setJSON(['error' => 'Access token not found.']);
    }

    $client = \Config\Services::curlrequest();
    $search = strtolower(trim($this->request->getGet('search') ?? ''));

    // Gunakan filter langsung jika ada pencarian
    $baseUrl = 'https://graph.microsoft.com/v1.0/users?$top=20&$select=id,displayName,jobTitle';

    if (!empty($search)) {
        $filter = "\$filter=startswith(displayName,'" . addslashes($search) . "')";
        $baseUrl .= '&' . $filter;
    }

    try {
        $res = $client->get($baseUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'ConsistencyLevel' => 'eventual'
            ]
        ]);

        $result = json_decode($res->getBody(), true);
        $users = $result['value'] ?? [];

        return $this->response->setJSON([
            'count' => count($users),
            'users' => $users
        ]);

    } catch (\Exception $e) {
        return $this->response->setJSON([
            'error' => 'Failed to fetch users',
            'message' => $e->getMessage()
        ]);
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
