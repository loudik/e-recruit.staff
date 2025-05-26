<?php


namespace App\Models;

use CodeIgniter\Model;

class Md_formregistration extends Model 
{
  protected $table = 'tbl_applicationjobs'; 
    // protected $primaryKey = 'id'; 
    protected $primaryKey = 'trxid';
    protected $useAutoIncrement = false;
    protected $allowedFields = [
      'idjobs', 'application', 'fullname','sexo', 'address', 'phone','email','trxid',
      'educationlevel', 'graduation', 'gpa',
      'language','authcount',
      'application','idtrx',
      'personalid','cv', 'diploma', 'transcript', 'coverletter',
      'iby', 'idt' 
  ];
  
    public function fn_getdatabytrxid($trxid) 
  {
      $query = $this->db->table($this->table)
          ->select('id,trxid, email, isstatus, otp, authcount')
          ->where('trxid', $trxid)
          ->limit(1)
          ->get();     

      return $query->getRowArray(); 
  }

  public function fn_updateCount( $trxid, $authcount) 
  {
      $query = $this->db->query(
          "UPDATE tbl_applicationjobs SET authcount = ? WHERE trxid = ?", 
          [$authcount, $trxid]
      );

      return $query;
  }

  public function fn_updateStatus( $trxid, $isstatus) 
  {
      $query = $this->db->query(
          "UPDATE tbl_applicationjobs SET isstatus = ? WHERE trxid = ?", 
          [$isstatus, $trxid]
      );

      return $query;
  }






  public function fn_submit($fields) 
  {
    $result = $this->db->table('tbl_managementjobs')
        ->select('id, jobs')
        ->where(['id' => $fields['jobs'], 'isdeleted' => 0])
        ->get()
        ->getRowArray();

    if (!$result) return false;

    $data = [
        'fullname' => $fields['fullname'],
        'trxid' => $fields['trxid'],
        'application' => $result['jobs'],
        'idjobs' => $fields['jobs'],
        'phone' => $fields['phone'],
        'email' => $fields['email'],
        'address' => $fields['address'],
        'sexo' => $fields['sexo'],
        'graduation' => $fields['graduation'],
        // 'pob' => $fields['pob'],
        'otp' => $fields['otp'],
        'educationlevel' => $fields['educationlevel'],
        'gpa' => $fields['gpa'],
        'language' => $fields['language'],
        'personalid' => $fields['personalid'],
        'cv' => $fields['cv'],
        'coverletter' => $fields['coverletter'],
        'diploma' => $fields['diploma'],
        'transcript' => $fields['transcript'],
        'iby' => 'system',
        'idt' => date('Y-m-d H:i:s'),
    ];

    return $this->db->table('tbl_applicationjobs')->insert($data);
  }

    

  public function fn_getjobs($idtrx)
  {
     return $this->db->table('tbl_managementjobs')
        ->select('id,idtrx, jobs')
        ->where('idtrx', $idtrx)
        ->get()
        ->getRowArray();  
  }


    public function fn_getdata($id)
    {
        $builder = $this->db->table($this->table);   
        $builder->where('id', $id);
        $query = $builder->get();
        return $query->getRowArray();
    }
}