<?php

namespace App\Controllers;
use App\Models\Md_adminpanel;
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
      

        $sort    = $this->request->getGet('sort') ?? '0';
        $keyword = $this->request->getGet('q');
        $checksession = session()->get('login_id');
        if ($checksession == "") {
            $type = strtolower('internships');
        } else {
            $type = strtolower('Staff');
        }

        if (!empty($keyword)) {
            $this->data['jobs'] = $this->Md_adminpanel->searchJobs($keyword,$type);
        } else {
            $this->data['jobs'] = $this->Md_adminpanel->getSortedJobs($sort, 3, 0);
        }

        // Ambil langsung dari model tanpa cache
        $this->data['jobCategories']     = $this->Md_adminpanel->getJobByjob();
        $this->data['Levels']            = $this->Md_adminpanel->getExperienceLevelCounts();
        $this->data['categories']        = $this->Md_adminpanel->getCategories();
        $this->data['popular_keywords']  = $this->Md_adminpanel->getPopularKeywords();

        $this->data['keyword'] = $keyword;
        $this->data['sort']    = $sort;

        // Hitung jumlah internship
        // $this->data['jobTypes'] = $this->Md_adminpanel->getJobTypeCount();
        $jobTypes = $this->Md_adminpanel->getJobTypeCount();
        // $internshipCount = 0;
        // $staffCount = 0;



        // foreach ($jobTypes as $job) {
        //     if (strtolower($job['type']) === 'internships') {
        //         $internshipCount = $job['count'];
        //         // break;
        //     }if(strtolower($job['type']) === 'Staff') {
        //         $staffCount = $job['count'];
        //         // break;
        //     }
        // }

        $key= "";
        $count= "";
        foreach ($jobTypes as $job) {
        if($checksession == "" ){
            if (strtolower($job['type']) === strtolower('internships')) {
                $count = $job['count'];
                $key = "internships";
            }
        }else{
            if(strtolower($job['type']) === strtolower('Staff')) {
                $count = $job['count'];
                $key = "Staff";
            }
        }
        }

        

        $this->data['jobTypes'] = [
            [
                'type'  => $key,
                'count' => $count
            ]
        ];

        log_message('debug', '==> Home::index berhasil load data');

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

            // Simpan ke tbl_staffapply
            $userApply = [
                'login_id'         => $loginId,
                'fullname'         => $fullname,
                'username'         => $username,
                'email'            => $email,
                'password'         => $hashedPassword
            ];

            $this->Md_adminpanel->registerApply($userApply);

            return $this->response->setJSON(['response' => 'success', 'message' => 'Registration successful. Please log in.']);
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

        $jobs = $this->Md_adminpanel->fn_loadmanagejob($perPage, $offset,$type);
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
