<?php


namespace App\Models;

use CodeIgniter\Model;

class Md_formregistration extends Model 
{
  protected $table = 'tbl_candidates'; 
    protected $primaryKey = 'id'; 
    protected $allowedFields = [
        'jobs', 'fullname', 'dob', 'pob', 'sexo', 'address', 'phone',
        'educationlevel', 'graduation', 'gpa', 'languague',
        'cv', 'diploma', 'transcript', 'coverletter'
    ];

    public function fn_submit($jobs,$fullname, $email, $phone, $address, $sexo, $dob, $pob, $educationlevel, $graduation, $gpa, $language, $application,$newCvName, $newCoverletterName, $newDiplomaName, $newTranscriptName)
    {
      $query = $this->db->query("SELECT id, jobs FROM tbl_managementjobs WHERE id = ? AND isdeleted = 0", [$jobs]);
      $result = $query->getRowArray();
  
      if (!$result) {
          return false; 
      }
  
      $idunit = $result['id'];
      $unitname = $result['unitname']; 

       $data = [
            'fullname' => $fullname,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'sexo' => $sexo,
            'dob' => $dob,
            'pob' => $pob,
            'educationlevel' => $educationlevel,
            'graduation' => $graduation,
            'gpa' => $gpa,
            'language' => $language,
            'application' => $application,
            'cv' => $newCvName,
            'coverletter' => $newCoverletterName,
            'diploma' => $newDiplomaName,
            'transcript' => $newTranscriptName,
            'iby'=> 'system',
            'idt' => date('Y-m-d H:i:s'),
        ];
        return $this->insert($data);
    }


  public function fn_getjobs()
  {
    $query = $this->db->table('tbl_managementjobs')
        ->select('id, jobs') 
        ->orderBy('jobs', 'ASC') 
        ->get();
    return $query->getResultArray(); 
  }


    public function fn_getdata($id)
    {
        $builder = $this->db->table($this->table);   
        $builder->where('id', $id);
        $query = $builder->get();
        return $query->getRowArray();
    }
}