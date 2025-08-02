<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class GoogleOAuth extends BaseConfig
{
    public string $clientId = '277159580032-go4hmef4v3vdmdumlchi5mrdhnp71mnu.apps.googleusercontent.com';
    public string $clientSecret = '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'; // lengkapin sesuai milikmu
    public string $redirectUri = 'http://localhost:8080/auth/google/callback';
    public array  $scopes = ['email', 'profile'];
}
