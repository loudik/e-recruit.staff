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

        // Ambil semua menu dari tbl_treemenu
    public function getAllMenus()
    {
        return $this->db->table('tbl_treemenu')
            ->where('isdeleted', 0)
            ->orderBy('sort_order', 'asc')
            ->get()
            ->getResultArray();
    }

    // Ambil akses menu berdasarkan microsoft_id
    public function getAccessByMicrosoftId($microsoftId)
    {
        return $this->db->table('tbl_accessright')
            ->where('microsoft_id', $microsoftId)
            ->get()
            ->getRowArray(); // Kembalikan 1 baris
    }

 
    
    public function addAdministrator($employeeID, $department, $menuIDs, $displayName = null, $email = null)
{
    $builder = $this->db->table('tbl_accessright');

    // Gabungkan menu ID jadi CSV string
    $menuIDsString = implode(',', array_unique($menuIDs));

    // Cek apakah data sudah ada berdasarkan microsoft_id
    $existing = $builder->where('microsoft_id', $employeeID)->get()->getRow();

    if ($existing) {
        // Jika sudah ada, update hanya menu_ids
        $update = $builder->where('microsoft_id', $employeeID)
                          ->update([
                              'menu_ids'  => $menuIDsString,
                              'idt'       => date('Y-m-d H:i:s'),
                              'iby'       => session()->get('email') ?? 'system',
                          ]);

        if ($update) {
            return ['success' => true, 'message' => 'Access updated.'];
        } else {
            return ['success' => false, 'message' => 'Failed to update access.'];
        }

    } else {
        // Jika belum ada, insert baru
        $data = [
            'microsoft_id'  => $employeeID,
            'display_name'  => $displayName,
            'email'         => $email,
            'department'    => $department,
            'menu_ids'      => $menuIDsString,
            'can_view'      => 1,
            'can_create'    => 0,
            'can_update'    => 0,
            'can_delete'    => 0,
            'isdeleted'     => 0,
            'iby'           => session()->get('email') ?? 'system',
            'idt'           => date('Y-m-d H:i:s')
        ];

        if ($builder->insert($data)) {
            return ['success' => true, 'message' => 'New access inserted.'];
        } else {
            return ['success' => false, 'message' => 'Failed to insert access.'];
        }
    }
}




/**
 * Ambil menu + daftar route berdasarkan microsoft_id.
 *
 * @return array [
 *     'treemenu' => string,   // HTML <li>…</li>
 *     'routes'   => string,   // "admin/dashboard,admin/report" (tanpa koma di akhir)
 * ]
 */
    public function getMenusByRole_($roleId): array
    {
        $user = $this->db->table('tbl_accessright')
            ->select('menu_ids')
            ->where('microsoft_id', $roleId)
            ->where('isdeleted', 0) 
            ->get()
            ->getFirstRow();

        $menuIds = [];

        if ($user && !empty($user->menu_ids)) {
            $menuIds = array_filter(array_map('intval', explode(',', $user->menu_ids)));
        }

        if (empty($menuIds)) {
            return [
                'treemenu' => '<li><a href="' . base_url('/admin/dashboard') . '"><span class="fa fa-home"></span> Dashboard</a></li>',
                'routes'   => ['admin/dashboard'],
            ];
        }

        $menus = $this->db->table('tbl_treemenu')
            ->where('isdeleted', 0)
            ->where('isactive', 1)
            ->whereIn('id', $menuIds)
            ->orderBy('sort_order', 'asc')
            ->get()
            ->getResultArray();

        log_message('debug', 'Menus fetched from DB: ' . print_r($menus, true));

        $baseUrl    = base_url('/');
        $treemenu   = '';
        $routeParts = [];

        foreach ($menus as $menu) {
            if (empty($menu['menuurl'])) {
                continue;
            }

            $url  = strtolower(trim($menu['menuurl']));
            $icon = esc($menu['menuicon'] ?: 'fa fa-circle-o');
            $name = esc($menu['menuname']);
            $sort_order = esc($menu['sort_order']);
            $idmenu = esc($menu['id']);
            $parent_id = esc($menu['parent_id']);
            
            $treemenu .= "
            <ul class=\"list-unstyled\">
                <li>
                    <a href=\"{$baseUrl}{$url}\">
                        <span class=\"{$icon}\">
                    </span> {$name}</a>
                </li>
            </ul>
            ";
            $routeParts[] = $url;

            log_message('debug', "Rendered menu ID {$menu['id']} → {$url}");
        }

        $extraRoutes = [
            'admin/users-json',
            'admin/addnewadmin',
            'admin/get-menuaccess',
            'admin/administrator/details',
            'admin/administrator/delete',
            'admin/addnewjobs',
            'admin/newjobs',
            'admin/getCategoriesByGroup',
            'admin/candidate',
            'admin/candidate/getcandidate',
            'admin/candidate/view',
            'admin/file/viewbyfilename',
            'admin/updatestatusadmin',
            'admin/report/getreport',
        ];

        foreach ($extraRoutes as $r) {
            $r = strtolower($r);
            if (!in_array($r, $routeParts)) {
                $routeParts[] = $r;
            }
        }
        return [
            'treemenu' => $treemenu,
            'routes'   => $routeParts, 
        ];
    }


    public function getMenusByRole($roleId): array
    {
        $user = $this->db->table('tbl_accessright')
            ->select('menu_ids')
            ->where('microsoft_id', $roleId)
            ->where('isdeleted', 0)
            ->get()
            ->getFirstRow();

        $menuIds = [];

        if ($user && !empty($user->menu_ids)) {
            $menuIds = array_filter(array_map('intval', explode(',', $user->menu_ids)));
        }

        if (empty($menuIds)) {
            return [
                'treemenu' => '<li><a href="' . base_url('/admin/dashboard') . '"><span class="fa fa-home"></span> Dashboard</a></li>',
                'routes'   => ['admin/dashboard'],
            ];
        }

        $menus = $this->db->table('tbl_treemenu')
            ->where('isdeleted', 0)
            ->where('isactive', 1)
            ->whereIn('id', $menuIds)
            ->orderBy('sort_order', 'asc')
            ->get()
            ->getResultArray();

        $menuTree = $this->buildMenuTree($menus);
        $treemenu = $this->renderMenuTree($menuTree, base_url('/'));

        $routeParts = [];
        foreach ($menus as $menu) {
            if (!empty($menu['menuurl'])) {
                $routeParts[] = strtolower(trim($menu['menuurl']));
            }
        }

        $extraRoutes = [
            'admin/users-json', 'admin/addnewadmin', 'admin/get-menuaccess',
            'admin/administrator/details', 'admin/administrator/delete',
            'admin/addnewjobs', 'admin/newjobs', 'admin/getCategoriesByGroup',
            'admin/candidate', 'admin/candidate/getcandidate', 'admin/candidate/view',
            'admin/file/viewbyfilename', 'admin/updatestatusadmin', 'admin/report/getreport',
        ];

        foreach ($extraRoutes as $r) {
            $r = strtolower($r);
            if (!in_array($r, $routeParts)) {
                $routeParts[] = $r;
            }
        }

        return [
            'treemenu' => $treemenu,
            'routes'   => $routeParts,
        ];
    }



    private function buildMenuTree(array $elements, int $parentId = 0): array
    {
        $branch = [];

        foreach ($elements as $element) {
            if ((int)$element['parent_id'] === $parentId) {
                $children = $this->buildMenuTree($elements, (int)$element['id']);
                if (!empty($children)) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }


    private function renderMenuTree(array $menuTree, string $baseUrl): string
    {
        $html = '<ul class="list-unstyled">';

        foreach ($menuTree as $menu) {
            $url  = strtolower(trim($menu['menuurl']));
            $icon = esc($menu['menuicon'] ?: 'fa fa-circle-o');
            $name = esc($menu['menuname']);
            $hasChildren = isset($menu['children']) && count($menu['children']) > 0;

            $html .= '<li>';

            if ($hasChildren) {
                // Tambahkan class untuk toggle
                $html .= '<a href="#" class="menu-toggle"><span class="' . $icon . '"></span> ' . $name . '</a>';
                $html .= $this->renderMenuTree($menu['children'], $baseUrl);
            } else {
                $html .= '<a href="' . $baseUrl . $url . '"><span class="' . $icon . '"></span> ' . $name . '</a>';
            }

            $html .= '</li>';
        }

        $html .= '</ul>';
        return $html;
    }

}