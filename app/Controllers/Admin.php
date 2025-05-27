<?php

namespace App\Controllers;
use App\Models\Md_adminpanel;

class Admin extends BaseController
{
    protected $Md_adminpanel; 
    public function __construct()
    {
        $this->Md_adminpanel = new Md_adminpanel();
    }
    public function fn_getadminpanel()
    {         
        $title = 'Admin Panel';
      return view('admin/vw_adminpanel');
    }

    public function fn_getdashboard()
    {   
        $range = $this->request->getGet('range') ?? 7;
        $data['title'] = 'Dashboard Admin Panel';
        $data['candidates'] = $this->Md_adminpanel->fn_getall();
        $data['jobs'] = $this->Md_adminpanel->fn_getjobcount();
        $data['applications'] = $this->Md_adminpanel->fn_getapplicationcount();
        $data['candidatesreject'] = $this->Md_adminpanel->fn_getcandidatereject();
        $data['candidateapprove'] = $this->Md_adminpanel->fn_getcandidateapprove();
        $data['applicationsCount'] = $this->Md_adminpanel->getApplicationsCount($range);
        $data['applicationsBeforeCount'] = $this->Md_adminpanel->getApplicationsBeforeCount($range);

        $growthPercent = 0;
        $isGrowthUp = false;
        if ($data['applicationsBeforeCount'] > 0) {
            $growthPercent = (($data['applicationsCount'] - $data['applicationsBeforeCount']) / $data['applicationsBeforeCount']) * 100;
            $isGrowthUp = $data['applicationsCount'] > $data['applicationsBeforeCount'];
        }

        $data['growthPercent'] = round($growthPercent, 1);
        $data['isGrowthUp'] = $isGrowthUp;
        $data['selectedDays'] = $range;

        return view('admin/vw_dashboard', $data);
    }




    public function getApplicationChartData()
    {
        $days = $this->request->getGet('range') ?? 7;
        $rawData = $this->Md_adminpanel->getChartData($days);
        $groupedData = [];
        foreach ($rawData as $row) {
            $groupedData[$row['date']] = (int) $row['count'];
        }
        $labels = [];
        $data = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            $labels[] = date('M d', strtotime($date));
            $data[] = $groupedData[$date] ?? 0;
        }

        return $this->response->setJSON([
            'labels' => $labels,
            'data' => $data
        ]);
    }


    public function getGenderStats()
    {
        $days = $this->request->getGet('range') ?? 7;
        $results = $this->Md_adminpanel->getGenderStats($days);
        if (empty($results)) {
            $results = $this->Md_adminpanel->getGenderStats(); 
        }

        $data = [
            'labels' => [],
            'values' => [],
        ];

        foreach ($results as $row) {
            $genderLabel = ucfirst(strtolower($row['sexo']));
            $data['labels'][] = $genderLabel;
            $data['values'][] = (int) $row['total'];
        }

        return $this->response->setJSON($data);
    }

    public function fn_action()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $requestData = $this->request->getJSON(true);
        $ids = $requestData['ids'] ?? [];
        $action = $requestData['action'] ?? '';

        if (empty($ids) || !in_array($action, ['approve', 'reject', 'delete'])) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid input']);
        }

        $success = $thi->Md_adminpanel->fn_updateaction($ids, $action);

        return $this->response->setJSON([
            'status' => $success ? 'success' : 'error',
            'message' => $success ? 'Bulk action completed' : 'Failed to process action'
        ]);
    }


    public function fn_getnewjobs()
    {         
      $data['title'] = 'New Jobs';
      $data['categories'] =  $this->Md_adminpanel->fn_getcategory();
      return view('admin/vw_newjobs', $data);
    }

    public function fn_getmanagejobs()
    {         
      $data['title'] = 'Manage Jobs';
    //   $data['jobs'] = $this->Md_adminpanel->fn_loadmanagejob();
      return view('admin/vw_managejobs', $data);
    }

    public function fn_getmanagedata()
    {

         $result = $this->Md_adminpanel->fn_getmanagedata();
        if (!empty($result)) {
          return $this->response->setJSON([
            'response' => 'success',
            'data' => $result
        ]);
        } else {
          return $this->response->setJSON([
            'response' => 'error',
            'message'  => 'No candidates found.'
          ]);
        }
    }



   public function updateJobStatus()
    {
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        if (!$id || $status === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request'
            ])->setStatusCode(400);
        }
        $updated = $this->Md_adminpanel->updateStatus($id, $status);

        return $this->response->setJSON([
            'success' => $updated,
            'message' => $updated ? 'Status updated successfully' : 'Gagal update status'
        ])->setStatusCode(200);
    }

     public function fn_searchjobs()
    {
        $keyword = $this->request->getGet('q') ?? '';
        $data = $this->Md_adminpanel->searchManageJobs($keyword);

        return $this->response->setJSON([
            'response' => 'success',
            'data' => $data
        ]);
    }


    public function fn_getcandidate()
    {         
      return view('admin/vw_candidate');
    }

    public function getcandidate()
    {
      $candidates = $this->Md_adminpanel->fn_getcandidate();
      if (!empty($candidates)) {
        return $this->response->setJSON([
          'response' => 'success',
          'data' => $candidates
      ]);
      } else {
        return $this->response->setJSON([
          'response' => 'error',
          'message'  => 'No candidates found.'
        ]);
      }
    }

    public function fn_approvecandidate()
    {
        $id = $this->request->getPost('id');
        $result = $this->Md_adminpanel->fn_approvecandidate($id);

        if ($result) {
            return $this->response->setJSON([
                'response' => 'success',
                'message'  => 'Candidate approved successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'response' => 'error',
                'message'  => 'Failed to approve candidate.'
            ]);
        }
    }

    public function fn_rejectcandidate()
    {
        $id = $this->request->getPost('id');
        $reason = $this->request->getPost('reason');

        $candidate = $this->Md_adminpanel->getCandidateById($id);
        if (!$candidate || empty($candidate['email'])) {
            return $this->response->setJSON([
                'response' => 'error',
                'message'  => 'Candidate email not found.'
            ]);
        }
        
        $result = $this->Md_adminpanel->fn_rejectcandidate($id, $reason);

        if ($result) {
            // Kirim email ke kandidat
            $emailService = \Config\Services::email();
            $emailService->setTo($candidate['email']);
            $emailService->setFrom('loudikmarkai@gmail.com', 'HR Recruitment');
            $emailService->setSubject('Application Rejection Notification');
            $emailService->setMessage(
                "Dear {$candidate['fullname']},\n\n" .
                "We regret to inform you that your application has been rejected.\n\n" .
                "Reason: {$reason}\n\n" .
                "Thank you for applying.\n\nBest regards,\nRecruitment Team"
            );

            if (!$emailService->send()) {
                log_message('error', '❌ Email gagal dikirim ke: ' . $candidate['email']);
                log_message('error', print_r($emailService->printDebugger(['headers', 'subject', 'body']), true));
            }

            return $this->response->setJSON([
                'response' => 'success',
                'message'  => 'Candidate rejected and email sent.'
            ]);
        } else {
            return $this->response->setJSON([
                'response' => 'error',
                'message'  => 'Failed to reject candidate.'
            ]);
        }
    }



    public function fn_viewcandidate()
    {
        $id = $this->request->getPost('id');
        $files = $this->Md_adminpanel->getCandidateDocuments($id);
        $candidate = $this->Md_adminpanel->getCandidateDetail($id);

        if (!$candidate || !is_array($candidate)) {
            return $this->response->setJSON([
                'response' => 'error',
                'message' => 'No candidate found.',
                'debug' => $candidate
            ]);
        }

        if (!$files || !is_array($files)) {
            return $this->response->setJSON([
                'response' => 'error',
                'message' => 'No files found.',
                'debug' => $files
            ]);
        }

        $documents = [
            'cv' => $files['cv'] ?? null,
            'diploma' => $files['diploma'] ?? null,
            'transcript' => $files['transcript'] ?? null,
            'coverletter' => $files['coverletter'] ?? null
        ];

        foreach ($documents as $key => $filename) {
          if ($filename) {
              $filePath = WRITEPATH . 'uploads/formapplicant/' . $filename;
              if (file_exists($filePath)) {
                $documents[$key] = $filename;
              } else {
                $documents[$key] = null; 
              }
          } else {
              $documents[$key] = null;
          }
      }
      

        return $this->response->setJSON([
            'response' => 'success',
            'data' => array_merge($candidate, $documents)
        ]);
    }


    public function previewCandidateFile($filename = null)
    {
      if (!$filename) {
        return $this->response->setStatusCode(400)->setBody('Missing filename');
      }
      $filePath = WRITEPATH . 'uploads/formapplicant/' . $filename;
      log_message('debug', 'Resolved realpath: ' . realpath($filePath));


      if (!file_exists($filePath)) {
          return $this->response->setStatusCode(404)->setBody('File not found');
      }
      $mime = mime_content_type($filePath);

      return $this->response
          ->setHeader('Content-Type', $mime)
          ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
          ->setBody(file_get_contents($filePath));

    }



    public function fn_deletecandidate()
    {
        $id = $this->request->getPost('id');
        $result = $this->Md_adminpanel->fn_deletecandidate($id);
        if ($result) {
            return $this->response->setJSON([
                'response' => 'success',
                'message'  => 'Candidate deleted successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'response' => 'error',
                'message'  => 'Failed to delete candidate.'
            ]);
        }
    }


    public function fn_getchangepw()
    {         
      $data['title'] = 'Change Password';
      return view('admin/vw_changepw', $data);
    }


    public function fn_getprofile()
    {         
      $data['title'] = 'Profile';
      return view('admin/vw_profile', $data);
    }


    public function fn_addnewjobs()
    {
        $jobs = $this->request->getPost('jobs');
        $location = $this->request->getPost('location');
        $category = $this->request->getPost('category');
        $jobdescription = $this->request->getPost('jobdescription');
        $experience = $this->request->getPost('experience');
        $level = $this->request->getPost('level');
        $type = $this->request->getPost('type');
        $applicants = $this->request->getPost('applicants');
        $applydate = $this->request->getPost('applydate');
        $dateexpire = $this->request->getPost('dateexpire');


        $addjobs = $this->Md_adminpanel->fn_addnewjobs(
            $jobs,
            $location,
            $category,
            $jobdescription,
            $experience,
            $level,
            $type,
            $applicants,
            $applydate,
            $dateexpire,
            $this->generateShortUniqueID(30)
        );

        // Kirim respons JSON
        if ($addjobs) {
            return $this->response->setJSON([
                'response' => 'success',
                'message' => 'Data submitted successfully!',
                'data' => $addjobs,
            ]);
        } else {
            return $this->response->setJSON([
                'response' => 'error',
                'message' => 'Failed to submit data!',
            ], 400);
        }
    }

    public function fn_editJob(){
      $id = $this->request->getPost('id');
      $categories = $this->Md_adminpanel->fn_getcategory();
      $data = $this->Md_adminpanel->fn_editJobs($id);
      if ($data) {
          return $this->response->setJSON([
              'response' => 'success',
              'message' => 'Data retrieved successfully!',
              'data' => $data,
              'categories' => $categories,
          ]);
      } else {
          return $this->response->setJSON([
              'response' => 'error',
              'message' => 'Failed to retrieve data!',
          ], 400);
      }
  }

  public function fn_updateJob()
  {
      // Ambil data dari form
      $jobData = [
          'id' => $this->request->getPost('id'),
          'jobs' => $this->request->getPost('jobs'),
          'location' => $this->request->getPost('location'),
          'category' => $this->request->getPost('category'),
          'experience' => $this->request->getPost('experience'),
          'level' => $this->request->getPost('level'),
          'type' => $this->request->getPost('type'),
          'applicants' => $this->request->getPost('applicants'),
          'applydate' => $this->request->getPost('applydate'),
          'dateexpire' => $this->request->getPost('dateexpire'),
          'jobdescription' => $this->request->getPost('jobdescription')
      ];

      log_message('error', 'Job Data: ' . print_r($jobData, true));
  
      // Pastikan data tidak kosong sebelum diproses
      if (empty($jobData['id']) || empty($jobData['jobs']) || empty($jobData['location']) || empty($jobData['category']|| empty($jobData['jobdescription']) || empty($jobData['experience']) || empty($jobData['level']) || empty($jobData['type']) || empty($jobData['applicants']) || empty($jobData['applydate']) || empty($jobData['dateexpire']))) {
          return $this->response->setJSON([
              'response' => 'error',
              'message' => 'Some required fields are missing!'
          ], 400);
      }
  
      // Panggil model untuk mengupdate data
      $result = $this->Md_adminpanel->fn_updateJob(
          $jobData['id'],
          $jobData['jobs'],
          $jobData['location'],
          $jobData['category'],
          $jobData['jobdescription'],
          $jobData['experience'],
          $jobData['level'],
          $jobData['type'],
          $jobData['applicants'],
          $jobData['applydate'],
          $jobData['dateexpire']
      );
  
      // Response berdasarkan hasil update
      if ($result) {
          return $this->response->setJSON([
              'response' => 'success',
              'message' => 'Data updated successfully!'
          ]);
      } else {
          return $this->response->setJSON([
              'response' => 'error',
              'message' => 'Failed to update data!'
          ], 400);
      }
  }


  public function fn_deleteJob()
  {
      $id = $this->request->getPost('id');
      $result = $this->Md_adminpanel->fn_deleteJob($id);

      if ($result) {
          return $this->response->setJSON([
              'response' => 'success',
              'message' => 'Job deleted successfully!',
          ]);
      } else {
          return $this->response->setJSON([
              'response' => 'error',
              'message' => 'Failed to delete job!',
          ], 400);
      }
  }


  
  
    


 



  }