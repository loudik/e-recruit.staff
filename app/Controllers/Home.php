<?php

namespace App\Controllers;
use App\Models\Md_adminpanel;
use Google\Client as GoogleClient;
// use App\Models\Md_home;

class Home extends BaseController
{
    protected $Md_adminpanel; 

    public function __construct()
    {
        $this->Md_adminpanel = new Md_adminpanel();
    }
   
    public function index()
{
    // --- session info untuk header ---
    $isLoggedIn = (bool) session('login_id');
    $this->data['displayName'] = session('fullname') ?: session('ms_name') ?: 'Guest';
    $this->data['roleLabel']   = $isLoggedIn ? 'Staff' : 'Candidate';

    // --- filter & pencarian ---
    $this->data['sort']    = (string) ($this->request->getGet('sort') ?? '0');
    $this->data['keyword'] = trim((string) ($this->request->getGet('q') ?? ''));
    $type                  = $isLoggedIn ? 'Staff' : 'Internships';

    if ($this->data['keyword'] !== '') {
        $this->data['jobs'] = $this->Md_adminpanel->searchJobs($this->data['keyword'], $type);
    } else {
        // kalau getSortedJobs punya argumen type, tambahkan; kalau tidak, biarkan seperti ini
        // $this->data['jobs'] = $this->Md_adminpanel->getSortedJobs($this->data['sort'], 3, 0, $type);
        $this->data['jobs'] = $this->Md_adminpanel->getSortedJobs($this->data['sort'], 3, 0);
    }

    // data pendukung
    $this->data['jobCategories']    = $this->Md_adminpanel->getJobByjob();
    $this->data['Levels']           = $this->Md_adminpanel->getExperienceLevelCounts();
    $this->data['categories']       = $this->Md_adminpanel->getCategories();
    $this->data['popular_keywords'] = $this->Md_adminpanel->getPopularKeywords();

    // hitung jumlah untuk type terpilih
    $jobTypes = $this->Md_adminpanel->getJobTypeCount();
    $selectedCount = 0;
    foreach ($jobTypes as $jt) {
        if (strcasecmp($jt['type'] ?? '', $type) === 0) {
            $selectedCount = (int) ($jt['count'] ?? 0);
            break;
        }
    }
    $this->data['jobTypes'] = [
        ['type' => $type, 'count' => $selectedCount]
    ];

    return view('layout/vw_dashboard', $this->data);
}


        public function fn_getloginpage()
        {
            $this->data['title'] = 'Page Login';
            return view('login/vw_pagelogin', $this->data);
            
        }


         public function fn_register()
        {
            $fullname        = $this->request->getPost('fullname');
            $email           = $this->request->getPost('email');
            $password        = $this->request->getPost('password');
            $confirmPassword = $this->request->getPost('confirm_password');
            $username        = $this->request->getPost('username');

            // var_dump($fullname, $email, $password, $confirmPassword, $username);return ;

            // Validasi input
            if ($password !== $confirmPassword) {
                return $this->response->setJSON(['response' => 'error', 'message' => 'Password and confirm password do not match.']);
            }
            if (empty($fullname) || empty($email) || empty($username) || empty($password)) {
                return $this->response->setJSON(['response' => 'error', 'message' => 'All fields are required.']);
            }
            if (strlen($password) < 8) {
                return $this->response->setJSON(['response' => 'error', 'message' => 'Password must be at least 8 characters long.']);
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $this->response->setJSON(['response' => 'error', 'message' => 'Invalid email format.']);
            }

            // Validasi unik
            if ($this->Md_adminpanel->getUserByEmail($email)) {
                return $this->response->setJSON(['response' => 'error', 'message' => 'Email is already registered.']);
            }
            if ($this->Md_adminpanel->getUserByUsername($username)) {
                return $this->response->setJSON(['response' => 'error', 'message' => 'Username is already registered.']);
            }

            // Simpan ke tbl_stafflogin
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $userLogin = [
                'fullname'  => $fullname,
                'email'     => $email,
                'username'  => $username,
                'password'  => $hashedPassword,
                'isdeleted' => 0,
                'isstatus'  => 1,
                'idt'       => date('Y-m-d H:i:s'),
            ];

            $loginId = $this->Md_adminpanel->registerUser($userLogin);
            if($loginId){
                $loginIdEmailStaff = $this->Md_adminpanel->getUserByEmailStaff($email);
                $userApply = [
                    'login_id'         => $loginIdEmailStaff["id"],
                    'fullname'         => $fullname,
                    'username'         => $username,
                    'email'            => $email,
                    'password'         => $hashedPassword
                ];
    
                $registerStaffApply = $this->Md_adminpanel->registerApply($userApply);

                if (!$registerStaffApply) {
                    return $this->response->setJSON(['response' => 'error', 'message' => 'Failed to register user details.']);
                }
    
                return $this->response->setJSON(['response' => 'success', 'message' => 'Registration successful. Please log in.']);
            }else{
                return $this->response->setJSON(['response' => 'error', 'message' => 'Registration failed. Please try again later.']);
            }

        }


    public function fn_validationlogin()
    {
        $email = $this->request->getPost('email'); // bisa email atau username
        $password = $this->request->getPost('password');

        if (empty($email) || empty($password)) {
            return $this->response->setJSON([
                'response' => 'error',
                'message'  => 'Email/Username and Password are required.'
            ]);
        }

        // Ambil data dari tbl_stafflogin
        $user = $this->Md_adminpanel->getLoginByIdentity($email);


        if(!$user['password']){
            return $this->response->setJSON([
                'response' => 'error',
                'message'  => 'Your user record login with Gmail, please login with Google.'
            ]);
        }

        if (!$user  || $user['isstatus'] != 1) {
            return $this->response->setJSON([
                'response' => 'error',
                'message'  => 'User not found or not active.'
            ]);
        }

        if (!password_verify($password, $user['password'])) {
            return $this->response->setJSON([
                'response' => 'error',
                'message'  => 'Incorrect password.'
            ]);
        }

        // Ambil data lengkap dari tbl_staffapply berdasarkan login_id
        $apply = $this->Md_adminpanel->getUserDetailByLoginId($user['id']);

        // Set session
        session()->set([
            'logged_in'  => true,
            'login_id'   => $user['id'],
            'username'   => $user['username'],
            'email'      => $user['email'],
            'fullname'   => $user['fullname']        
        ]);

        return $this->response->setJSON([
            'response' => 'success',
            'message'  => 'Login successful.'
        ]);
    }





    public function fn_getpages()
    {
        $checksession = session()->get('login_id');
        if ($checksession == "") {
            $type = strtolower('internships');
        } else {
            $type = strtolower('Staff');
        }
        $page = (int) $this->request->getGet('page') ?? 1;
        $perPage = 3;
        $offset = ($page - 1) * $perPage;

        $jobs = $this->Md_adminpanel->fn_loadmanagejob($type,$perPage, $offset);
        $total = $this->Md_adminpanel->fn_countmanagejob();

        return $this->response->setJSON([
            'jobs' => $jobs,
            'page' => $page,
            'total' => $total
        ]);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }


    public function fn_gethomepage()
    {
        $this->data['title'] = 'Homepage';
        return view('homepage/homepage',$this->data);
    }

}
