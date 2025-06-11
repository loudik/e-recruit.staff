<?php


namespace App\Models;

use CodeIgniter\Model;

class Md_login extends Model 
{
  protected $table = 'tbl_login'; 
  protected $primaryKey = 'id'; 


  public function getUserByUsername($username)
  {
      return $this->where('username', $username)
                  ->where('isdeleted', 0)
                  ->first();
  }

}