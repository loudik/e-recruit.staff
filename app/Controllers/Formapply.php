<?php



namespace App\Controllers;
use App\Models\Md_formregistration;

class Formapply extends BaseController
{
  protected $Md_formregistration; 

  public function __construct()
    {
      $this->Md_formregistration = new Md_formregistration(); 
    }
    public function fn_getdataregistration()
    {
 
      $id=$this->request->getGet('id');
      $data['jobs'] =  $this->Md_formregistration->fn_getjobs();
      return view('form/vw_formapply', ['data' => $data]);
    
    }

    public function fn_submitdataregistration()
{

  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
  header("Access-Control-Allow-Headers: Content-Type, Authorization");

  // Tangani preflight OPTIONS request
  if ($this->request->getMethod() === 'options') {
      return $this->response->setStatusCode(200);
  }
    $jobs = $this->request->getPost('jobs');
    $fullname = $this->request->getPost('fullname');
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

    // Files
    $cv = $this->request->getFile('cv');
    $coverletter = $this->request->getFile('coverletter');
    $diploma = $this->request->getFile('diploma');
    $transcript = $this->request->getFile('transcript');

    $uploadPath = WRITEPATH . 'uploads/formapplicant/';
    $allowedExtensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];

    // Buat folder jika belum ada
    if (!is_dir($uploadPath)) {
        mkdir($uploadPath, 0755, true);
    }

    // Validasi semua file
    $files = compact('cv', 'coverletter', 'diploma', 'transcript');
    $newFileNames = [];

    foreach ($files as $key => $file) {
        $ext = strtolower($file->getClientExtension());

        if (!$file->isValid() || !in_array($ext, $allowedExtensions)) {
            return $this->response->setJSON([
                'response' => 'error',
                'message' => "File '$key' is not valid or type is not allowed!",
            ]);
        }

        $file->move($uploadPath, $file->getRandomName());
        $newFileNames[$key] = $file->getName();
    }

    // Simpan ke DB via model
    $addform = $this->Md_formregistration->fn_submit(
        $jobs,
        $fullname,
        $phone,
        $address,
        $sexo,
        $dob,
        $pob,
        $educationlevel,
        $gpa,
        $language,
        $newFileNames['cv'],
        $newFileNames['coverletter'],
        $newFileNames['diploma'],
        $newFileNames['transcript']
    );

    if ($addform) {
        $data = [
            'response' => 'success',
            'message' => 'Data submitted successfully!',
            'data' => $addform
        ];
    } else {
        log_message('error', 'Gagal submit data. Input: ' . json_encode($this->request->getPost()));
        $data = [
            'response' => 'error',
            'message' => 'Failed to submit data!',
        ];
    }

    return $this->response->setJSON($data);
}

  public function fn_comfirmemail()
  {
    $email = $this->request->getPost('email');

    if ($email) {
      session()->set('email', $email);
      $otp = rand(100000, 999999);

      $otpCmd = escapeshellcmd("/home/projectanp/projectCI4/mygolang/buildemail $otp $email");
      $output = shell_exec($otpCmd);

      return $this->response->setJSON([
        'response' => 'success',
        'message'  => 'OTP sent to email.',
      ]);
    }
    return $this->response->setJSON([
      'response' => 'error',
      'message'  => 'Email is required.',
    ]);
  }




}
