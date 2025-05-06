<?php

namespace App\Controllers;
use App\Models\Md_adminpanel;

class Admin extends BaseController
{
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
          $data['title'] = 'Dashboard';
        return view('admin/vw_dashboard', $data);
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
      $data['jobs'] = $this->Md_adminpanel->fn_loadmanagejob();
      return view('admin/vw_managejobs', $data);
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

    public function fn_viewcandidate()
    {
        $id = $this->request->getPost('id');
        $data = $this->Md_adminpanel->fn_viewcandidate($id);
        if ($data) {
            return $this->response->setJSON([
                'response' => 'success',
                'data' => $data
            ]);
        } else {
            return $this->response->setJSON([
                'response' => 'error',
                'message'  => 'Candidate not found.'
            ]);
        }
    }

    public function viewfile($id = null, $type = null)
    {
        if (!$id || !$type) {
            return $this->response->setJSON([
                'response' => 'error',
                'message' => 'Missing ID or document type.'
            ]);
        }

        $allowedTypes = ['cv', 'diploma', 'transcript', 'coverletter'];
        if (!in_array($type, $allowedTypes)) {
            return $this->response->setJSON([
                'response' => 'error',
                'message' => 'Invalid document type.'
            ]);
        }

        
        $filename = $this->Md_adminpanel->getCandidateDocumentFilename($id, $type);

        if (!$filename) {
            return $this->response->setJSON([
                'response' => 'error',
                'message' => 'File not registered in database.'
            ]);
        }

        $filePath = WRITEPATH . 'uploads/formapplicant/' . $filename;

        if (!file_exists($filePath)) {
            return $this->response->setJSON([
                'response' => 'error',
                'message' => 'File not found on server.'
            ]);
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
            $dateexpire
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

  public function fn_login(){
      $email = $this->request->getPost('email');
      $password = $this->request->getPost('password');
  
      // Validasi input
      if (empty($email) || empty($password)) {
          return $this->response->setJSON([
            'response' => 'error',
            'message' => 'Username and password are required!',
          ], 400);
      }
  
      $result = $this->Md_adminpanel->fn_login($email);
  
      if ($result) {
          return $this->response->setJSON([
              'response' => 'success',
              'message' => 'Login successful!',
              'data' => $result,
          ]);
      } else {
          return $this->response->setJSON([
              'response' => 'error',
              'message' => 'Invalid username or password!',
          ], 401);
      }
  }
  
  
    


 



  }