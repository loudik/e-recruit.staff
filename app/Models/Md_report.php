<?php


namespace App\Models;

use CodeIgniter\Model;

class Md_report extends Model 
{
  protected $table = 'tbl_applicationjobs'; 
  protected $primaryKey = 'id'; 


  public function fn_getreport($start = null, $end = null)
{
    $builder = $this->db->table('tbl_applicationjobs a');
    $builder->select([
        'a.fullname',
        'a.application',
        'a.phone',
        'a.email',
        'a.sexo',
        'a.educationlevel',
        'a.graduation',
        'a.gpa',
        'a.isstatus',
        'c.groupname',
        'b.unitname',
        'a.idt'
    ]);
    $builder->join('tbl_unit b', 'a.idjobs = b.id');
    $builder->join('tbl_group c', 'b.idgroup = c.id');
    $builder->where('a.isdeleted', 0);
    $builder->whereIn('a.isstatus', [1, 2, 3]);

    if ($start && $end) {
        $builder->where("DATE_FORMAT(a.idt, '%Y-%m') >=", $start);
        $builder->where("DATE_FORMAT(a.idt, '%Y-%m') <=", $end);
    }

    $builder->orderBy('a.id', 'ASC');
    return $builder->get()->getResultArray();
}






}