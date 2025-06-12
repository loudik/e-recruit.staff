<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveMenuIdFromAccessright extends Migration
{
    public function up()
{
    if ($this->db->fieldExists('menu_id', 'tbl_accessright')) {
        $this->forge->dropColumn('tbl_accessright', 'menu_id');
    }
}

public function down()
{
    $this->forge->addColumn('tbl_accessright', [
        'menu_id' => [
            'type'       => 'INT',
            'constraint' => 11,
            'unsigned'   => true,
            'null'       => false,
            'after'      => 'menu_ids',
        ],
    ]);
}

}
