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
 
      $idtrx=$this->request->getGet('idtrx');
      $job = $this->Md_formregistration->fn_getjobs($idtrx);
      if (!$job) {
        return redirect()->to('');
      }else{

        $data['job'] = $job;
        return view('form/vw_formapply', $data);
      }
    
    }

  public function fn_submitdataregistration()
  {

      $fields = [
        'jobs' => $this->request->getPost('jobs'),
        'fullname' => $this->request->getPost('fullname'),
        'email' => $this->request->getPost('email'),
        'phone' => $this->request->getPost('phone'),
        'address' => $this->request->getPost('address'),
        'sexo' => $this->request->getPost('sexo'),
        'educationlevel' => $this->request->getPost('educationlevel'),
        'graduation' => $this->request->getPost('graduation'),
        'gpa' => $this->request->getPost('gpa'),
        'language' => $this->request->getPost('language'),
        'otp' => rand(100000, 999999),
        'trxid' => rand(100000000000, 999999999999)
    ];


    
    foreach ($fields as $field => $value) {
        if (empty($value)) {
            return $this->response->setJSON([
              'response' => 'error',
              'message' => ucfirst($field) . ' is required!',
            ]);
        }
    }
    
      if (!filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) {
          return $this->response->setJSON([
            'response' => 'error',
            'message' => 'Invalid email format!',
          ]);
      }

      if (!preg_match('/^[0-9]{10,15}$/', $fields['phone'])) {
          return $this->response->setJSON([
            'response' => 'error',
            'message' => 'Invalid phone number format!',
          ]);
      }
      if (!preg_match('/^[0-9]{1,2}(\.[0-9]{1,2})?$/', $fields['gpa'])) {
          return $this->response->setJSON([
            'response' => 'error',
            'message' => 'Invalid GPA format!',
          ]);
      }

      // Files
      $personalid = $this->request->getFile('personalid');
      $cv = $this->request->getFile('cv');
      $coverletter = $this->request->getFile('coverletter');
      $diploma = $this->request->getFile('diploma');
      $transcript = $this->request->getFile('transcript');

      $uploadPath = WRITEPATH . 'uploads/formapplicant/';
      if (!is_dir($uploadPath)) {
          mkdir($uploadPath, 0755, true);
      }
      
      $prefix = $this->remSpace($fields['fullname']);
      
    

      $cvUpload = $this->uploadFile($cv, $prefix . '_cv', $uploadPath);
      if (isset($cvUpload['error'])) return $this->response->setJSON(['response' => 'error', 'message' => $cvUpload['error']]);
      
      $coverUpload = $this->uploadFile($coverletter, $prefix . '_cover', $uploadPath);
      if (isset($coverUpload['error'])) return $this->response->setJSON(['response' => 'error', 'message' => $coverUpload['error']]);
      
      $diplomaUpload = $this->uploadFile($diploma, $prefix . '_diploma', $uploadPath);
      if (isset($diplomaUpload['error'])) return $this->response->setJSON(['response' => 'error', 'message' => $diplomaUpload['error']]);
      
      $transcriptUpload = $this->uploadFile($transcript, $prefix . '_transcript', $uploadPath);
      if (isset($transcriptUpload['error'])) return $this->response->setJSON(['response' => 'error', 'message' => $transcriptUpload['error']]);

      $personalidUpload = $this->uploadFile($personalid, $prefix . '_personalid', $uploadPath);
      if (isset($personalidUpload['error'])) return $this->response->setJSON(['response' => 'error', 'message' => $personalidUpload['error']]);
      
      $fields['personalid'] = $personalidUpload['filename'];
      $fields['cv'] = $cvUpload['filename'];
      $fields['coverletter'] = $coverUpload['filename'];
      $fields['diploma'] = $diplomaUpload['filename'];
      $fields['transcript'] = $transcriptUpload['filename'];

      // Simpan ke DB via model
      $addform = $this->Md_formregistration->fn_submit($fields);

      if ($addform) {
          $checkemail = $this->fn_comfirmemail($fields['otp'], $fields['email']);
          if($checkemail) {
              $this->createSessionOTP($fields);
              log_message('info', 'Data submitted successfully. Input: ' . json_encode($this->request->getPost()));
              $data = [
                'response' => 'success',
                'message' => 'Data submitted successfully!',
              ];
          } else {
              log_message('error', 'Failed to send email. Input: ' . json_encode($this->request->getPost()));
              $data = [
                'response' => 'error',
                'message' => 'Failed to send confirmation email!',
              ];
          }
      } else {
          log_message('error', 'Gagal submit data. Input: ' . json_encode($this->request->getPost()));
          $data = [
              'response' => 'error',
              'message' => 'Failed to submit data!',
          ];
      }
      return $this->response->setJSON($data);
  }


  public function uploadFile($file, $prefix, $uploadPath, $allowedExtensions = ['pdf', 'docx'], $maxSizeMB = 20)
  {
      if (!$file || !$file->isValid()) {
          return ['error' => $file ? $file->getErrorString() : 'File not uploaded'];
      }

      $realPath = realpath($uploadPath);
      if ($realPath === false || !is_writable($realPath)) {
          log_message('error', 'Upload path not writable: ' . $uploadPath);
          return ['error' => 'Upload path is not writable: ' . $uploadPath];
      }

      $ext = strtolower($file->getClientExtension());
      if (!in_array($ext, $allowedExtensions)) {
          return ['error' => 'Invalid file extension: ' . $ext];
      }

      // Cek ukuran file
      $maxBytes = $maxSizeMB * 1024 * 1024;
      if ($file->getSize() > $maxBytes) {
          return ['error' => 'File too large. Max: ' . $maxSizeMB . 'MB'];
      }

      $filename = $prefix . '_' . uniqid() . '.' . $ext;
      try {
          $file->move($realPath, $filename);
      } catch (\Exception $e) {
          return ['error' => 'Failed to move file: ' . $e->getMessage()];
      }

      return ['filename' => $filename];
  }





  public function fn_comfirmemail($otp, $email)
  {
      $url = "http://localhost:9999/send-otp?otp={$otp}&email=" . urlencode($email);
      
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, [
          "Authorization: Bearer BearerMySecretToken123", 
          "Accept: application/json"
      ]);

      $response = curl_exec($ch);
      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      $curlError = curl_error($ch);
      $curldata = curl_close($ch);

      if ($response === false || $httpcode !== 200) {
          log_message('error', 'Failed to send OTP. Curl Error: ' . $curlError . '. HTTP Code: ' . $httpcode . '. Response: ' . $response);
          return false;
      }

      $json = json_decode($response, true);
      if (isset($json['status']) && $json['status'] === 'ok') {
          return true;
      }

      return true; 
  }

  public function fn_comfirmotp()
  {
      $otp = $this->request->getPost('otp');
      $sessiontrxid = session()->get('trxid');
      $checkDBuser = $this->Md_formregistration->fn_getdatabytrxid($sessiontrxid);
      // var_dump($sessiontrxid);return;

      if ($checkDBuser) {
        $dbOTP = $checkDBuser['otp'];
        if ($otp != $dbOTP) {
          if ($checkDBuser['authcount'] >= 3) {
            if (session()->has('trxid')) {
                session()->remove('trxid');
            }
            return $this->response->setJSON([
                'response' => 'error',
                'message' => 'OTP confirmation failed! Account locked.',
                'trxid' => "TRXID-RESET-SESSION",
            ]);
          }else{
            $authCount = $checkDBuser['authcount'] + 1;
            $this->Md_formregistration->fn_updateCount($checkDBuser['trxid'], ['authcount' => $authCount]);
            
            return $this->response->setJSON([
                'response' => 'error',
                'message' => 'Invalid OTP!',
            ]);
          }
        }else{
            $this->Md_formregistration->fn_updateStatus($checkDBuser['trxid'], ['isstatus' => 1]);
            if (session()->has('trxid')) {
                session()->remove('trxid');
            }
            return $this->response->setJSON([
              'response' => 'success',
              'message' => 'OTP confirmed successfully!',
          ]);
        } 
      } else {
        return $this->response->setJSON([
            'response' => 'error',
            'message' => 'User undefined!',
        ]);
      }
  }
}
