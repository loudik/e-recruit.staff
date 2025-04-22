<?php


namespace App\Models;

use CodeIgniter\Model;

class Md_adminpanel extends Model 
{
  protected $table = 'tbl_unit'; 
  protected $primaryKey = 'id'; 

  public function fn_getcategory()
  {
    $query = $this->db->query("SELECT * FROM tbl_unit where isdeleted = 0  order by unitname asc");
    return $query->getResultArray();
  }



  public function fn_addnewjobs($jobs, $location, $category, $jobdescription, $experience, $level, $type, $applicants, $applydate, $dateexpire)
  {
    $query = $this->db->query("SELECT id, unitname FROM tbl_unit WHERE id = ? AND isdeleted = 0", [$category]);
    $result = $query->getRowArray();

    if (!$result) {
        return false; 
    }

    $idunit = $result['id'];
    $unitname = $result['unitname']; 

    $data = [
        'jobs' => $jobs,
        'loc' => $location,
        'idunit' => $idunit,
        'category' => $unitname, 
        'jobdescription' => $jobdescription,
        'experiences' => $experience,
        'level' => $level,
        'type' => $type,
        'applicants' => $applicants,
        'applydate' => $applydate,
        'dateexpire' => $dateexpire,
        'iby' => '30580', // ID user yang membuat
        'idt' => date('Y-m-d H:i:s'),
        'isdeleted' => 0,
    ];

    return $this->db->table('tbl_managementjobs')->insert($data); // Simpan data ke tabel tbl_managementjobs
  }

  public function fn_loadmanagejob()
  {
    $query = $this->db->query("SELECT * FROM tbl_managementjobs WHERE isdeleted = 0 ORDER BY id DESC");
    return $query->getResultArray();
  }

  public function fn_editJobs($id)
  {
    $query = $this->db->query("SELECT * FROM tbl_managementjobs WHERE id = ? AND isdeleted = 0", [$id]);
    return $query->getRowArray();
  }
  public function fn_updateJob($id, $jobs, $location, $category, $jobdescription, $experience, $level, $type, $applicants, $applydate, $dateexpire)
  {
      $query = $this->db->query("SELECT id, unitname FROM tbl_unit WHERE id = ? AND isdeleted = 0", [$category]);
      $result = $query->getRowArray();
  
      if (!$result) {
          return false; 
      }
  
      $idunit = $result['id'];
      $unitname = $result['unitname']; 
  
      $data = [
          'jobs'           => $jobs,
          'loc'            => $location,
          'idunit'         => $idunit,
          'category'       => $unitname,
          'jobdescription' => $jobdescription,
          'experiences'    => $experience,
          'level'          => $level,
          'type'           => $type,
          'applicants'     => $applicants,
          'applydate'      => $applydate,
          'dateexpire'     => $dateexpire,
          'uby'            => '30580', 
          'udt'            => date('Y-m-d H:i:s'),
      ];
  
      return $this->db->table('tbl_managementjobs')->update($data, ['id' => $id]); 
  }

  public function fn_deleteJob($id)
  {
      $data = [
        'isdeleted' => 1,
        'uby' => '30580', // ID user yang menghapus
        'udt' => date('Y-m-d H:i:s')];
      return $this->db->table('tbl_managementjobs')->update($data, ['id' => $id]);
  }

  public function fn_login($email)
  {
      // Ambil dari tbl_employee berdasarkan email
      $employee = $this->db->table('tbl_employee')
          ->select('id as idemployee')
          ->where('email', $email)
          ->get()
          ->getRowArray();
  
      if ($employee) {
          // Cek apakah idemployee ada di tbl_password
          $check = $this->db->table('tbl_password')
              ->where('idemployee', $employee['idemployee'])
              ->get()
              ->getRowArray();
  
          if ($check) {
              return $employee; // Login berhasil
          }
      }
  
      return null; // Login gagal
  }
  


  


}