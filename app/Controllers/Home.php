<?php

namespace App\Controllers;
use App\Models\Md_adminpanel;
// use App\Models\Md_home;

class Home extends BaseController
{

    public function __construct()
    {
        $this->Md_adminpanel = new Md_adminpanel();
    }
    public function index()
    {
        $sort = $this->request->getGet('sort') ?? '0';
        $keyword = $this->request->getGet('q');

        if (!empty($keyword)) {
            $data['jobs'] = $this->Md_adminpanel->searchJobs($keyword);
        } else {
            $data['jobs'] = $this->Md_adminpanel->getSortedJobs($sort, 3, 0);
        }

        $jobTypes = $this->Md_adminpanel->getJobTypeCount();
        $data['Levels'] = $this->Md_adminpanel->getExperienceLevelCounts();
        $data['jobCategories'] = $this->Md_adminpanel->getJobByjob();
        $data['categories'] = $this->Md_adminpanel->getCategories();
        $data['popular_keywords'] = $this->Md_adminpanel->getPopularKeywords();
        $data['keyword'] = $keyword;
        $data['sort'] = $sort;

        // Hitung internships
        $internshipCount = 0;
        foreach ($jobTypes as $job) {
            if ($job['type'] === 'internships') {
                $internshipCount = $job['count'];
                break;
            }
        }

        $data['jobTypes'] = [
            [
                'type' => 'internships',
                'count' => $internshipCount
            ]
        ];

        return view('layout/vw_dashboard', $data);
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

}
