<?php

use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;


if (!function_exists('cookieCache')) {
    function cookieCache(string $key, int $duration, callable $callback)
    {
        helper('cookie');

        $request = Services::request();
        $cookie  = $request->getCookie($key);

        if (!empty($cookie)) {
            $decoded = json_decode($cookie, true);
            if (is_array($decoded)) {
                log_message('debug', "cookieCache: menggunakan cookie '$key'");
                return $decoded;
            }

            log_message('warning', "cookieCache: cookie '$key' rusak: " . json_last_error_msg());
        }

        // Fallback ambil data dari DB
        log_message('debug', "cookieCache: memanggil callback untuk '$key'");
        $data = $callback();

        if (!headers_sent()) {
            set_cookie([
                'name'     => $key,
                'value'    => json_encode($data),
                'expire'   => $duration,
                'httponly' => false,
                'path'     => '/',
                'samesite' => 'Lax',
                'secure'   => false,
            ]);
            log_message('debug', "cookieCache: cookie '$key' berhasil diset");
        } else {
            log_message('warning', "cookieCache: gagal set cookie '$key' karena headers sudah dikirim");
        }

        return $data;
    }
}