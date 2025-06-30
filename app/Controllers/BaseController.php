<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;
    protected $session;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];
    protected $data = [];
    protected $menu;

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        $this->session = service('session');
        $this->data['logoPath'] = base_url('anplogo.png');
        // $this->data['sidebarMenus'] = $this->loadSidebarMenus();
        // $role_id = $this->session->get('microsoft_id') ?? 0;
        // $this->menu = model('App\Models\Md_administrator')->getMenuByRole($role_id);
    }

    public function generateShortUniqueID($length = 16)
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $result;
    }





    public function createSessionOTP($userData) 
    {
        $sessionData = [
            'trxid'           => $userData['trxid'],
            
        ];
        session()->set($sessionData);
    }

    public function uploadFile($file, $prefix, $uploadPath, $allowedExtensions = ['pdf', 'doc', 'docx'], $maxSizeMB = 10)
    {
        if (!$file || !$file->isValid()) {
            return ['error' => "File is not valid.". $file];
        }

        $ext = strtolower($file->getClientExtension());
        if (!in_array($ext, $allowedExtensions)) {
            return ['error' => 'File type not allowed.'];
        }

        if ($file->getSizeByUnit('mb') > $maxSizeMB) {
            return ['error' => "File size must not exceed {$maxSizeMB} MB."];
        }

        $random = bin2hex(random_bytes(5));
        $newName = "{$prefix}_{$random}.{$ext}";
        $newNameDB = "{$prefix}_{$random}";
        $file->move($uploadPath, $newName);

        return ['filename' => $newNameDB];
    }

    public function remSpace($string) 
    { 
        $string = preg_replace('/\s+/', '', $string); 
        return $string; 
    }

    protected function getLogoBase64($relativePath = 'assets/images/anplogo.png')
    {
        $fullPath = FCPATH . $relativePath;

        if (!file_exists($fullPath)) {
            return null;
        }

        $type = pathinfo($fullPath, PATHINFO_EXTENSION);
        $data = file_get_contents($fullPath);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }


}
