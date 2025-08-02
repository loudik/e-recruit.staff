<?php


namespace App\Models;

use CodeIgniter\Model;

class Md_adminpanel extends Model 
{
  protected $table = 'tbl_applicationjobs'; 
  protected $primaryKey = 'id'; 


  public function getCategoryByEmailFromJob($email)
{
    return $this->db->table('tbl_staffapply sa')
        ->select('mj.type')
        ->join('tbl_managementjobs mj', 'mj.id = sa.job_id')
        ->where('sa.email', $email)
        ->get()
        ->getRowArray();
}





  public function fn_getcategory()
  {
    $query = $this->db->query("SELECT * FROM tbl_unit where isdeleted = 0  order by unitname asc");
    return $query->getResultArray();
  }

  public function fn_getgroup()
  {
    $query = $this->db->query("SELECT * FROM tbl_group where isdeleted = 0  order by groupname asc");
    return $query->getResultArray();
  }

  public function fn_getcategorybygroup($groupId)
    {
        return $this->db->table('tbl_unit')
            ->where('isdeleted', 0)
            ->where('idgroup', $groupId)
            ->orderBy('unitname', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getUserByEmail($email)
    {
        $query = $this->db->query("SELECT * FROM tbl_staffapply WHERE email = ? AND isdeleted = 0", [$email]);
        return $query->getRowArray();
    }

    public function getUserByUsername($username)
    {
        $query = $this->db->query("SELECT * FROM tbl_staffapply WHERE username = ? AND isdeleted = 0", [$username]);
        return $query->getRowArray();
    }

    public function getUserByEmailStaff($email)
    {
        $query = $this->db->query("SELECT * FROM tbl_stafflogin WHERE email = ? AND isdeleted = 0", [$email]);
        return $query->getRowArray();
    }

    public function registerUser($userData)
    {
        return $this->db->table('tbl_stafflogin')->insert($userData);
    }

    public function registerApply($data)
    {
        return $this->db->table('tbl_staffapply')->insert($data);
    }


    // Cek berdasarkan username atau email
    public function getLoginByIdentity($email)
    {
        return $this->db->table('tbl_stafflogin')
            ->groupStart()
                ->where('email', $email)
            ->groupEnd()
            ->get()->getRowArray();
    }

    // Ambil detail user dari tbl_staffapply berdasarkan login_id
    public function getUserDetailByLoginId($loginId)
    {
        return $this->db->table('tbl_staffapply')
            ->where('login_id', $loginId)
            ->get()->getRowArray();
    }







  public function fn_addnewjobs($jobs, $location, $category, $jobdescription, $experience, $level, $type, $applicants, $applydate, $dateexpire, $idtrx)
  {
    $query = $this->db->query("SELECT id, unitname FROM tbl_unit WHERE id = ? AND isdeleted = 0", [$category]);
    $result = $query->getRowArray();

    if (!$result) {
        return false; 
    }

    $idunit = $result['id'];
    $unitname = $result['unitname']; 

    $data = [
        'idtrx' => $idtrx,
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
        'iby' => '30580', 
        'idt' => date('Y-m-d H:i:s'),
        'isdeleted' => 0,
    ];

    return $this->db->table('tbl_managementjobs')->insert($data);
  }
  public function getJobTypeCount()
  {
      $sql = "SELECT type, COUNT(*) AS count 
              FROM tbl_managementjobs 
              WHERE isdeleted = 0 
              GROUP BY type";
  
      return $this->db->query($sql)->getResultArray();
  }

  public function fn_getall()
  {
      return $this->where('isdeleted', 0)
                  ->where('isstatus', 2)
                  ->findAll();
  }

    
    
  public function fn_getjobcount()
  {
      $query = $this->db->query("SELECT COUNT(*) as count FROM tbl_managementjobs WHERE isdeleted = 0");
      return $query->getRowArray()['count'];
  }

  public function fn_getapplicationcount()
{
    return $this->db->table('tbl_applicationjobs')
                    ->where('isdeleted', 0)
                    ->countAllResults();
}

public function fn_getcandidatereject()
{
    return $this->db->table('tbl_applicationjobs')
                    ->where('isdeleted', 0)
                    ->where('isstatus', 3)
                    ->countAllResults();
}

public function fn_getdetailcandidate($id)
{
    return $this->db->table('tbl_applicationjobs')
        ->where('id', $id)
        ->get()
        ->getRowArray(); 
}

public function fn_getcandidateapprove()
{
    return $this->db->table('tbl_applicationjobs')
                    ->where('isdeleted', 0)
                    ->where('isstatus', 2)
                    ->countAllResults();
}

public function getExperienceLevelCounts()
{
    return $this->db->table('tbl_managementjobs')
                ->select('level, COUNT(*) as count')
                ->where('isdeleted', 0)
                ->groupBy('level')
                ->get()
                ->getResultArray();
}

public function updateStatus($id, $newStatus)
{
    return $this->db->table('tbl_managementjobs')
                    ->where('id', $id)
                    ->update(['status' => $newStatus]);
}


public function fn_updatestatusadmin($id, $newStatus)
{
    return $this->db->table('tbl_accessright')
                    ->where('id', $id)
                    ->update(['isstatus' => $newStatus]);
}




public function getJobByjob()
{
    return $this->db->query("
        SELECT 
            j.idunit, 
            j.category,
            (
                SELECT COUNT(*) 
                FROM tbl_managementjobs 
                WHERE isdeleted = 0 AND idunit = j.idunit
            ) AS count
        FROM tbl_managementjobs j
        WHERE j.isdeleted = 0
        AND j.id = (
            SELECT MIN(id) 
            FROM tbl_managementjobs 
            WHERE isdeleted = 0 AND idunit = j.idunit
        )
        ORDER BY count DESC
    ")->getResultArray();
}



public function getCategories()
{
    return $this->db->table('tbl_managementjobs')
        ->select('category')
        ->where('isdeleted', 0)
        ->groupBy('category')
        ->orderBy('category', 'ASC')
        ->get()
        ->getResultArray();
}



  public function getApplicationsCount($days = 7)
  {
      return $this->db->table('tbl_applicationjobs')
          ->where('isdeleted', 0)
          ->where('idt >=', date('Y-m-d 00:00:00', strtotime("-{$days} days")))
          ->countAllResults();
  }

  public function getApplicationsBeforeCount($days = 7)
  {
      $start = date('Y-m-d 00:00:00', strtotime("-{$days} days"));
      $end   = date('Y-m-d 00:00:00', strtotime("-" . ($days * 2) . " days"));

      return $this->db->table('tbl_applicationjobs')
          ->where('isdeleted', 0)
          ->where('idt >=', $end)
          ->where('idt <', $start)
          ->countAllResults();
  }

  public function getChartData($days = 7)
  {
      return $this->select("DATE(idt) AS date, COUNT(*) AS count")
          ->where('isdeleted', 0)
          ->where('idt >=', date('Y-m-d 00:00:00', strtotime("-{$days} days")))
          ->groupBy('DATE(idt)')
          ->orderBy('DATE(idt)', 'ASC')
          ->findAll();
  }



    public function getGenderStats($days = null)
    {
      $builder = $this->db->table('tbl_applicationjobs')
          ->select('sexo as sexo, COUNT(*) as total')
          ->groupBy('sexo');
      if ($days !== null) {
          $builder->where('idt >=', date('Y-m-d', strtotime("-{$days} days")));
      }

      return $builder->get()->getResultArray();
    }

    public function getLevelStats($days = null)
    {
        $builder = $this->db->table('tbl_managementjobs')
            ->select('level, COUNT(*) as total')
            ->where('isdeleted', 0)
            ->groupBy('level');

        if ($days !== null) {
            $builder->where('idt >=', date('Y-m-d', strtotime("-{$days} days")));
        }

        return $builder->get()->getResultArray();
    }

    public function getCandidateTypeStats($days = null)
    {
        $builder = $this->db->table('tbl_managementjobs')
            ->select('type, COUNT(*) as total')
            ->where('isdeleted', 0);

        if ($days !== null) {
            $builder->where('idt >=', date('Y-m-d', strtotime("-{$days} days")));
        }

        return $builder->groupBy('type')->get()->getResultArray();
    }



  public function fn_loadmanagejob($limit = 3, $offset = 0,$type)
  {
    $query = $this->db->query(
        "SELECT * FROM tbl_managementjobs WHERE type = '$type' AND  isdeleted = 0 AND status=0 ORDER BY id DESC LIMIT ? OFFSET ?",
        [$limit, $offset]
    );

    return $query->getResultArray(); 
  }

    public function getSortedJobs($sort = '0', $limit = 3, $offset = 0)
    {
        $builder = $this->db->table('tbl_managementjobs')
            ->where('isdeleted', 0)
            ->where('status', 0); // ✅ hanya status aktif

        // Terapkan urutan berdasarkan sort
        if ($sort === '1') {
            $builder->orderBy('idt', 'DESC'); // Newest
        } elseif ($sort === '2') {
            $builder->orderBy('idt', 'ASC'); // Oldest
        } else {
            $builder->orderBy('id', 'DESC'); // Most relevant (default)
        }

        return $builder->limit($limit, $offset)->get()->getResultArray();
    }


    public function searchJobs($keyword,$type)
    {

        return $this->db->table('tbl_managementjobs')
            ->where('isdeleted', 0)
            ->where('type', $type)
            ->where('status', 0) // ✅ hanya job yang aktif
            ->groupStart()
                ->like('jobs', $keyword)
                ->orLike('category', $keyword)
                ->orLike('loc', $keyword)
            ->groupEnd()
            ->orderBy('id', 'DESC')
            ->get()
            ->getResultArray();
    }


    public function getPopularKeywords()
    {
        $query = $this->db->query("
            SELECT LOWER(jobs) AS job_title FROM tbl_managementjobs WHERE isdeleted = 0
        ");
        $rows = $query->getResultArray();

        $keywords = [];
        foreach ($rows as $row) {
            $words = explode(' ', strtolower($row['job_title']));
            $keywords = array_merge($keywords, $words);
        }

        $common = ['from', 'the', 'and', 'with', 'for', 'a', 'to', 'in'];
        $keywords = array_filter($keywords, fn($w) => !in_array($w, $common) && strlen($w) > 2);

        $counts = array_count_values($keywords);
        arsort($counts);

        return array_slice(array_keys($counts), 0, 10);
    }

    public function fn_updateaction(array $ids, string $action)
    {
      if (empty($ids)) return false;
      switch ($action) {
          case 'approve':
              return $this->db->table('tbl_applicationjobs')
                  ->whereIn('id', $ids)
                  ->update(['isstatus' => 2]);

          case 'reject':
              return $this->db->table('tbl_applicationjobs')
                  ->whereIn('id', $ids)
                  ->update(['isstatus' => 3]);

          case 'delete':
              return $this->db->table('tbl_applicationjobs')
                  ->whereIn('id', $ids)
                  ->delete();

          default:
              return false;
      }
    }





  public function fn_countmanagejob()
{
    return $this->db->table('tbl_managementjobs')
        ->where('isdeleted', 0)
        ->countAllResults();
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


  public function fn_deleteaccess($id)
  {
      $data = [
        'isdeleted' => 1,
        'uby' => 'System',
        'udt' => date('Y-m-d H:i:s')];
      return $this->db->table('tbl_accessright')->update($data, ['id' => $id]);
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
  
      return null; 
  }

public function fn_approvecandidate($id,$totalPoint)
{
    $data = [
      'isstatus' => 2,
      'reason' => 'Candidate approved after successful review of qualifications and documentation',
      'reviewpoint' => $totalPoint, 
      'uby' => '30580',
      'udt' => date('Y-m-d H:i:s')
    ];
    return $this->db->table('tbl_applicationjobs')->update($data, ['id' => $id]);
}

public function fn_rejectcandidate($id,$reason = null)
{
    $data = [
      'isstatus' => 3,
      'uby' => '30580',
      'reason'   => $reason,
      'udt' => date('Y-m-d H:i:s')
    ];
    return $this->db->table('tbl_applicationjobs')->update($data, ['id' => $id]);
}

public function getCandidateById($id)
{
    return $this->db->table('tbl_applicationjobs')
        ->select('id, fullname, email')
        ->where('id', $id)
        ->get()
        ->getRowArray();
}


public function getCandidateDocuments($id)
{
    return $this->db
        ->table('tbl_applicationjobs') 
        ->select('id, cv, diploma, transcript, coverletter, personalid,application, fullname, email, graduation, educationlevel, language, gpa, address, phone, sexo,reason')
        ->where('id', $id)
        ->where('isdeleted', 0) 
        ->get()
        ->getRowArray(); 
}


public function getCandidateDetail($id)
{
    return $this->db->table('tbl_applicationjobs')->where('id', $id)->get()->getRowArray();
}


public function fn_getcandidate()
{
    $query = $this->db->query("SELECT * FROM tbl_applicationjobs WHERE isdeleted = 0 AND isstatus IN (1, 2,3) ORDER BY id DESC");
    return $query->getResultArray();
}


public function fn_getmanagedata()
{
    $query = $this->db->query("
        SELECT 
            a.*, 
            b.unitname AS category, 
            c.groupname
        FROM tbl_managementjobs a
        JOIN tbl_unit b ON a.idunit = b.id
        JOIN tbl_group c ON b.idgroup = c.id
        WHERE a.isdeleted = 0
        ORDER BY a.id DESC
    ");
    return $query->getResultArray();
}


// MODEL
public function fn_detailadministrator()
{
    // Ambil data accessright
    $results = $this->db->table('tbl_accessright')
        ->where('isdeleted', 0)
        ->get()
        ->getResultArray();

    // Ambil semua menu (peta ID → nama)
    $menus = $this->db->table('tbl_treemenu')
        ->select('id, menuname')
        ->where('isactive', 1)
        ->where('isdeleted', 0)
        ->get()
        ->getResultArray();

    $menuMap = [];
    foreach ($menus as $menu) {
        $menuMap[$menu['id']] = $menu['menuname'];
    }

    // Proses tiap baris accessright
    $data = [];
    $no = 1;
    foreach ($results as $row) {
        $menuNames = [];

        if (!empty($row['menu_ids'])) {
            $ids = explode(',', $row['menu_ids']);

            foreach ($ids as $id) {
                $id = (int) trim($id);
                if (isset($menuMap[$id])) {
                    $menuNames[] = $menuMap[$id];
                }
            }
        }

        $row['no'] = $no++;
        $row['menu_names'] = implode(', ', $menuNames); // ⬅️ ini yang ditampilkan
        $data[] = $row;
    }

    return $data;
}








 public function searchManageJobs($keyword)
{
    return $this->db->table('tbl_managementjobs')
        ->groupStart()
            ->like('jobs', $keyword)
            ->orLike('category', $keyword)
        ->groupEnd()
        ->where('isdeleted', 0)
        ->orderBy('id', 'DESC')
        ->get()
        ->getResultArray();
}



  public function fn_viewcandidate($id)
  {
    $query = $this->db->query("SELECT * FROM tbl_applicationjobs WHERE id = ? AND isdeleted = 0", [$id]);
    return $query->getRowArray();
  }

  public function fn_deletecandidate($id)
  {
      $data = [
        'isdeleted' => 1,
        'uby' => '30580',
        'udt' => date('Y-m-d H:i:s')];
      return $this->db->table('tbl_applicationjobs')->update($data, ['id' => $id]);
  }
  


  


}