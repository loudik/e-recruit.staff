<?php


namespace App\Models;

use CodeIgniter\Model;

class Md_administrator extends Model
{
    protected $table = 'tbl_treemenu';

    public function getMenuByRole($role_id)
    {
        return $this->db->table('tbl_accessright a')
            ->select('m.menuname, m.menuurl, m.menuicon')
            ->join('tbl_treemenu m', 'a.menu_id = m.id')
            ->where('a.role_id', $role_id)
            ->where('m.isdeleted', 0)
            ->orderBy('m.sort_order', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getAllMenus()
    {
        return $this->db->table('tbl_treemenu')
            ->where('isdeleted', 0)
            ->orderBy('sort_order', 'asc')
            ->get()
            ->getResultArray();
    }


}