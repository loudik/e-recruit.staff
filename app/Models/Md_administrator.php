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
                'treemenu' => '<li><a href="' . base_url('/admin/dashboard') . '"><span class="fa fa-home"></span>Dashboard</a></li>',
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


    public function getMenusByRole(string $roleId): array
{
    // ambil menu_ids yang boleh
    $user = $this->db->table('tbl_accessright')
        ->select('menu_ids')
        ->where('microsoft_id', $roleId)
        ->where('isdeleted', 0)
        ->get()->getFirstRow();

    $menuIds = [];
    if ($user && !empty($user->menu_ids)) {
        $menuIds = array_filter(array_map('intval', explode(',', $user->menu_ids)));
    }

    // kalau kosong, biarkan view handle dashboard sendiri
    if (empty($menuIds)) {
        return ['treemenu' => '', 'routes' => ['admin/dashboard']];
    }

    // ambil rows sesuai akses
    $rows = $this->db->table('tbl_treemenu')
        ->where('isdeleted', 0)
        ->where('isactive', 1)
        ->whereIn('id', $menuIds)
        ->orderBy('sort_order', 'asc')
        ->get()->getResultArray();

    // build tree berdasarkan parent_id dari DB (sesuai definisi tabel)
    $tree = $this->buildMenuTree($rows);

    // render ke markup template (m-link / ms-link + collapse)
    $currentPath = trim(service('uri')->getPath(), '/');
    [$html, $routes] = $this->renderSidebarTemplate($tree, $currentPath);

    // tambahkan route ekstra bila perlu (opsional)
    $extraRoutes = [
        'admin/users-json','admin/addnewadmin','admin/get-menuaccess',
        'admin/administrator/details','admin/administrator/delete',
        'admin/addnewjobs','admin/newjobs','admin/getCategoriesByGroup',
        'admin/candidate','admin/candidate/getcandidate','admin/candidate/view',
        'admin/file/viewbyfilename','admin/updatestatusadmin','admin/report/getreport',  'admin/vacancy',
        'admin/vacancy/approve','admin/vacancyapproval/approve', 'admin/vacancyverify/signature','admin/vacancy/do-approve','admin/vacancy/receive','admin/vacancy/do-receive','admin/vacancyapproval/receive',
        'admin/notifyhrds','admin/notifyhrds/loadnotify'
        
    ];
    foreach ($extraRoutes as $r) {
        $r = strtolower($r);
        if (!in_array($r, $routes, true)) $routes[] = $r;
    }

    return ['treemenu' => $html, 'routes' => $routes];
}

/** Build tree dari rows flat (pakai parent_id dari DB) */
private function buildMenuTree(array $rows): array
{
    $byId = [];
    foreach ($rows as $r) {
        $r['children'] = [];
        $byId[(int)$r['id']] = $r;
    }
    $roots = [];
    foreach ($byId as $id => &$n) {
        $pid = (int)($n['parent_id'] ?? 0);
        if ($pid && isset($byId[$pid])) {
            $byId[$pid]['children'][] = &$n;
        } else {
            $roots[] = &$n;
        }
    }
    return $roots;
}


private function renderSidebarTemplate(array $nodes, string $currentPath, int $depth = 0): array
{
    $html = '';
    $routes = [];

    foreach ($nodes as $n) {
        $url   = ltrim(strtolower(trim((string)($n['menuurl'] ?? ''))), '/'); // contoh: admin/reports
        $name  = esc($n['menuname'] ?? 'Menu', 'html');
        $icon  = trim((string)($n['menuicon'] ?? '')); // IKUTI DB (fa/icofont/bi), tidak diubah
        if ($icon === '') $icon = 'icofont-ui-bulleted-list';

        $children = $n['children'] ?? [];
        $hasKids  = !empty($children);

        $isActiveSelf = $url !== '' && ($currentPath === $url || str_starts_with($currentPath, $url.'/'));
        if ($url) $routes[] = $url;

        // render anak dulu untuk tahu apakah ada yang aktif (tentukan "show")
        $childHtml = '';
        $childActive = false;
        if ($hasKids) {
            [$childHtml, $childRoutes, $childActive] = $this->renderSubmenuTemplate($children, $currentPath, $depth + 1);
            $routes = array_merge($routes, $childRoutes);
        }

        if ($depth === 0) { // ROOT
            if ($hasKids) {
                $collapseId = 'menu-' . (int)$n['id'];
                $liClass    = ($isActiveSelf || $childActive) ? '' : 'collapsed';
                $showClass  = ($isActiveSelf || $childActive) ? ' show' : '';

                $html .= '<li class="'.$liClass.'">';
                $html .=   '<a class="m-link" data-bs-toggle="collapse" data-bs-target="#'.$collapseId.'" href="#">'
                        .  '<i class="'.$icon.' fs-5"></i> <span>'.$name.'</span>'
                        .  '<span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span>'
                        .  '</a>';
                $html .=   '<ul class="sub-menu collapse'.$showClass.'" id="'.$collapseId.'">'.$childHtml.'</ul>';
                $html .= '</li>';
            } else {
                $activeCls = $isActiveSelf ? ' active' : '';
                $html .= '<li><a class="m-link'.$activeCls.'" href="'.site_url($url).'">'
                      .  '<i class="'.$icon.' fs-5"></i> <span>'.$name.'</span></a></li>';
            }
        } else { // CHILDREN (depth >= 1)
            if ($hasKids) {
                $collapseId = 'menu-' . (int)$n['id'];
                $liClass    = ($isActiveSelf || $childActive) ? '' : 'collapsed';
                $showClass  = ($isActiveSelf || $childActive) ? ' show' : '';

                $html .= '<li class="'.$liClass.'">';
                $html .=   '<a class="ms-link" data-bs-toggle="collapse" data-bs-target="#'.$collapseId.'" href="#">'
                        .  $name
                        .  '<span class="arrow icofont-rounded-down ms-auto text-end fs-6"></span>'
                        .  '</a>';
                $html .=   '<ul class="sub-menu collapse'.$showClass.'" id="'.$collapseId.'">'.$childHtml.'</ul>';
                $html .= '</li>';
            } else {
                $activeCls = $isActiveSelf ? ' active' : '';
                $html .= '<li><a class="ms-link'.$activeCls.'" href="'.site_url($url).'">'.$name.'</a></li>';
            }
        }
    }

    return [$html, array_values(array_unique($routes))];
}

/** Render anak + info apakah ada yang aktif (untuk membuka parent) */
private function renderSubmenuTemplate(array $children, string $currentPath, int $depth): array
{
    [$html, $routes] = $this->renderSidebarTemplate($children, $currentPath, $depth);
    $hasActive = str_contains($html, ' class="ms-link active"') || str_contains($html, ' class="m-link active"');
    return [$html, $routes, $hasActive];
}




}