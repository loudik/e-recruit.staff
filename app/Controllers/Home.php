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

        if (!empty($keyword)) {
            $this->data['jobs'] = $this->Md_adminpanel->searchJobs($keyword);
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
        $jobTypes = $this->Md_adminpanel->getJobTypeCount();
        $internshipCount = 0;

        foreach ($jobTypes as $job) {
            if (strtolower($job['type']) === 'internships') {
                $internshipCount = $job['count'];
                break;
            }
        }

        $this->data['jobTypes'] = [
            [
                'type'  => 'internships',
                'count' => $internshipCount
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




   





    public function fn_getpages()
    {
        $page = (int) $this->request->getGet('page') ?? 1;
        $perPage = 3;
        $offset = ($page - 1) * $perPage;

        $jobs = $this->Md_adminpanel->fn_loadmanagejob($perPage, $offset);
        $total = $this->Md_adminpanel->fn_countmanagejob();

        return $this->response->setJSON([
            'jobs' => $jobs,
            'page' => $page,
            'total' => $total
        ]);
    }


    public function fn_gethomepage()
    {
        $this->data['title'] = 'Homepage';
        return view('homepage/homepage',$this->data);
    }

}
