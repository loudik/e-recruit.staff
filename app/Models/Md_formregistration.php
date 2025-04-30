<?php


namespace App\Models;

use CodeIgniter\Model;

class Md_formregistration extends Model 
{
  protected $table = 'tbl_applicationjobs'; 
    protected $primaryKey = 'id'; 
    protected $allowedFields = [
      'idjobs', 'application', 'fullname', 'dob', 'pob', 'sexo', 'address', 'phone',
      'educationlevel', 'graduation', 'gpa',
      'language', // ← tambahkan ini
      'application',
      'cv', 'diploma', 'transcript', 'coverletter',
      'iby', 'idt' // ← tambahkan ini
  ];
  

  public function fn_submit(
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
    $newCvName,
    $newCoverletterName,
    $newDiplomaName,
    $newTranscriptName
) {
    $result = $this->db->table('tbl_managementjobs')
        ->select('id, jobs')
        ->where(['id' => $jobs, 'isdeleted' => 0])
        ->get()
        ->getRowArray();

    if (!$result) return false;

    $data = [
        'fullname' => $fullname,
        'idjobs' => $result['id'],
        'application' => $result['jobs'],
        'phone' => $phone,
        'address' => $address,
        'sexo' => $sexo,
        'dob' => $dob,
        'pob' => $pob,
        'educationlevel' => $educationlevel,
        'gpa' => $gpa,
        'language' => $language,
        'cv' => $newCvName,
        'coverletter' => $newCoverletterName,
        'diploma' => $newDiplomaName,
        'transcript' => $newTranscriptName,
        'iby' => 'system',
        'idt' => date('Y-m-d H:i:s'),
    ];

    return $this->db->table('tbl_applicationjobs')->insert($data);
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