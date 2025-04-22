<?php


namespace App\Models;

use CodeIgniter\Model;

class Md_formregistration extends Model 
{
  protected $table = 'tbl_jobapplications'; 
    protected $primaryKey = 'id'; 
    protected $allowedFields = [
        'fullname', 'email', 'phone', 'address', 'sexo', 'dob', 'pob',
        'educationlevel', 'graduation', 'gpa', 'language', 'application',
        'cv', 'coverletter', 'diploma', 'transcript'
    ];

    public function fn_submit($fullname, $email, $phone, $address, $sexo, $dob, $pob, $educationlevel, $graduation, $gpa, $language, $application,$newCvName, $newCoverletterName, $newDiplomaName, $newTranscriptName)
    {
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

    public function fn_getdata($id)
    {
        $builder = $this->db->table($this->table);   
        $builder->where('id', $id);
        $query = $builder->get();
        return $query->getRowArray();
    }
}