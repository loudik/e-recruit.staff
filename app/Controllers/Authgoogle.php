<?php

namespace App\Controllers;
use App\Models\Md_adminpanel;
use Google\Client as GoogleClient;
use Google\Service\Oauth2;

class Authgoogle extends BaseController
{
    protected $Md_adminpanel; 

    public function __construct()
    {
        $this->Md_adminpanel = new Md_adminpanel();
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

    public function fn_submitusergoogle()
    {
        $config = config('GoogleOAuth');
        $client = new \Google_Client();
        $client->setClientId($config->clientId);
        $client->setClientSecret($config->clientSecret);
        $client->setRedirectUri($config->redirectUri);
        $client->setScopes($config->scopes);

        if ($this->request->getGet('code')) {
            $token = $client->fetchAccessTokenWithAuthCode($this->request->getGet('code'));
            $client->setAccessToken($token['access_token']);

            $oauth2 = new \Google_Service_Oauth2($client);
            $userInfo = $oauth2->userinfo->get();

            $email = $userInfo->getEmail();
            $name = $userInfo->getName();
            $username = $userInfo["givenName"];
            $verified_email = $userInfo["verified_email"];

            $user = $this->Md_adminpanel->getUserByEmail($email); 

            // var_dump($userInfo);return;
            if (!$user) {
                if (!$verified_email) {
                    return redirect()->to('/loginpage')->with('error', 'Your email is not verified. Please verify your email first.');
                }else{
                        $userLogin = [
                        'fullname'  => $name,
                        'email'     => $email,
                        'username'  => $username,
                        'isdeleted' => 0,
                        'isstatus'  => 1,
                        'idt'       => date('Y-m-d H:i:s'),
                    ];

                    $loginId = $this->Md_adminpanel->registerUser($userLogin);
                    if($loginId){
                        $loginIdEmailStaff = $this->Md_adminpanel->getUserByEmailStaff($email);
                        $userApply = [
                            'login_id'         => $loginIdEmailStaff["id"],
                            'fullname'         => $name,
                            'username'         => $username,
                            'email'            => $email,
                            // 'password'         => $hashedPassword
                        ];
            
                        $registerStaffApply = $this->Md_adminpanel->registerApply($userApply);

                        session()->set([
                            'login_id'    => $loginIdEmailStaff['id'],
                            'login_email' => $email,
                            'login_name'  => $name,
                            'login_type'  => 'google',
                        ]);
                        
                        return redirect()->to('/home');

                        if (!$registerStaffApply) {
                            return $this->response->setJSON(['response' => 'error', 'message' => 'Failed to login user.']);
                        }
            
                        return $this->response->setJSON(['response' => 'success', 'message' => 'Registration successful. Please log in.']);
                    }else{
                        return $this->response->setJSON(['response' => 'error', 'message' => 'Registration failed. Please try again later.']);
                    }
                    
                }
            }

            session()->set([
                'login_id'    => $user['id'],
                'login_email' => $user['email'],
                'login_name'  => $user['fullname'],
                'login_type'  => 'google',
            ]);

            return redirect()->to('/home');
        }

        return redirect()->to('/login');
    }

  }