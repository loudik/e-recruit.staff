<?php

namespace App\Controllers;
use App\Models\Md_formregistration;

class Formapply extends BaseController
{
    public function __construct()
    {
        $this->Md_formregistration = new Md_formregistration();
    }
    public function fn_getdataregistration()
    {
      $id = $this->request->getGet('id');
      $data = $this->Md_formregistration->fn_getdata($id);
      $data['jobs'] = $this->Md_formregistration->fn_getjobs();
      return view('form/vw_formapply', ['data' => $data]);
    }

    public function fn_submitdataregistration()
    {
        $jobs = $this->request->getGet('jobs');
        $fullname = $this->request->getPost('fullname');
        $email = $this->request->getPost('email');
        $phone = $this->request->getPost('phone');
        $address = $this->request->getPost('address');
        $sexo = $this->request->getPost('sexo');
        $dob = $this->request->getPost('dob');
        $pob = $this->request->getPost('pob');
        $educationlevel = $this->request->getPost('educationlevel');
        $graduation = $this->request->getPost('graduation');
        $gpa = $this->request->getPost('gpa');
        $language = $this->request->getPost('language');
        $application = $this->request->getPost('application');
        $cv = $this->request->getFile('cv');
        $coverletter = $this->request->getFile('coverletter');
        $diploma = $this->request->getFile('diploma');
        $transcript = $this->request->getFile('transcript');

        $uploadPath = ROOTPATH . 'home/app/upload/recruitment';
        $allowedExtensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];

        if ($cv->isValid() && $coverletter->isValid() && $diploma->isValid() && $transcript->isValid()) {
            $cv->move($uploadPath, $cv->getRandomName());
            $coverletter->move($uploadPath, $coverletter->getRandomName());
            $diploma->move($uploadPath, $diploma->getRandomName());
            $transcript->move($uploadPath, $transcript->getRandomName());

            $newCvName = $cv->getName();
            $newCoverletterName = $coverletter->getName();  
            $newDiplomaName = $diploma->getName();
            $newTranscriptName = $transcript->getName();
            $addform =$this->Md_formregistration->fn_submit($jobs,$fullname, $email, $phone, $address, $sexo, $dob, $pob, $educationlevel, $graduation, $gpa, $language, $application, $newCvName, $newCoverletterName, $newDiplomaName, $newTranscriptName);

            if ($addform){
                $data =[
                    'response' => 'success',
                    'message' => 'Data submitted successfully!',
                    'data' => $addform
                ];
            }else{
                $data =[
                    'response' => 'error',
                    'message' => 'Failed to submit data!',
                ];
            }
        } else {
            $data = [
                'response' => 'error',
                'message' => 'File upload failed!',
                'data' => null
            ];
        }
        return $this->response->setJSON($data);
      
    }
}
