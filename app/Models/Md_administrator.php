<?php


namespace App\Models;

use CodeIgniter\Model;

class Md_administrator extends Model
{
    protected $table = 'tbl_accessright';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'role_id',
        'menu_id',
        'department',
        'can_view',
        'can_create',
        'can_update',
        'can_delete',
        'isdeleted',
        'iby',
        'idt'
    ];

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

    
    public function addAdministrator($employeeID, $department, $menuIDs)
{
    $builder = $this->db->table('tbl_accessright');

    // Hapus yang lama
    $builder->where('role_id', $employeeID)->delete();

    // Hilangkan duplikat
    $menuIDs = array_unique($menuIDs);

    $menuIDsString = implode(',', array_unique($menuIDs));

    // return $menuIDsString;

    $data = [
        'microsoft_id'    => $employeeID,
        'department' => $department,
        'menu_ids'    => $menuIDsString,
        'can_view'   => 1,
        'can_create' => 0,
        'can_update' => 0,
        'can_delete' => 0,
        'isdeleted'  => 0,
        'iby'        => session()->get('email') ?? 'system',
        'idt'        => date('Y-m-d H:i:s')
    ];

    if ($builder->insert($data)) {
        return ['success' => true];
    }

    return [
        'success' => false,
        'message' => 'Failed to insert into tbl_accessright.'
    ];
}


/**
 * Ambil menu + daftar route berdasarkan microsoft_id.
 *
 * @return array [
 *     'treemenu' => string,   // HTML <li>…</li>
 *     'routes'   => string,   // "admin/dashboard,admin/report" (tanpa koma di akhir)
 * ]
 */
     public function getMenusByRole($roleId): array
    {
        // ------------------------------------------------------------------
        // 1. Ambil access–menu_id
        // ------------------------------------------------------------------
        $user = $this->db->table('tbl_accessright')
            ->select('menu_ids')                 // kolom TEXT hasil migrasi
            ->where('microsoft_id', $roleId)
            ->where('isdeleted', 0)
            ->get()
            ->getFirstRow();                    // cuma butuh 1 baris

        if (!$user || empty($user->menu_ids)) {
            // Tidak ada menu untuk role ini
            return ['treemenu' => '', 'routes' => ''];
        }

        // Ubah "1,2,3" ⇒ [1,2,3]
        $menuIds = array_filter(array_map('intval', explode(',', $user->menu_ids)));

        // ------------------------------------------------------------------
        // 2. Ambil detail menu
        // ------------------------------------------------------------------
        $menus = $this->db->table('tbl_treemenu')
            ->where('isdeleted', 0)
            ->where('isactive', 1)
            ->whereIn('id', $menuIds)
            ->orderBy('sort_order', 'asc')
            ->get()
            ->getResultArray();

        // ------------------------------------------------------------------
        // 3. Susun HTML & daftar route
        // ------------------------------------------------------------------
        $baseUrl    = base_url('/');
        $treemenu   = '';
        $routeParts = [];                       // kumpulkan route satu-per-satu

        foreach ($menus as $menu) {
            $url   = esc($menu['menuurl']);
            $icon  = esc($menu['menuicon'] ?: 'fa fa-circle-o');
            $name  = esc($menu['menuname']);

            $treemenu   .= "<li><a href=\"{$baseUrl}{$url}\"><span class=\"{$icon}\"></span> {$name}</a></li>";
            $routeParts[] = "/$url";
        }

        $routesSession = implode(',', $routeParts);   // <-- TANPA koma di akhir

        return [
            'treemenu' => $treemenu,
            'routes'   => $routesSession,
        ];
    }


}