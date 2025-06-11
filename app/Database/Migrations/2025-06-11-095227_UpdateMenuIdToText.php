<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateMenuIdToText extends Migration
{
    public function up()
    {
        if ($this->db->fieldExists('menu_ids', 'tbl_accessright')) {
            $this->forge->dropColumn('tbl_accessright', 'menu_ids');
        }

        $this->forge->addColumn('tbl_accessright', [
            'menu_ids' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'department', 
            ],
        ]);
    }

    public function down()
    {
        // Drop kolom TEXT
        if ($this->db->fieldExists('menu_ids', 'tbl_accessright')) {
            $this->forge->dropColumn('tbl_accessright', 'menu_id');
        }

        // Kembalikan ke VARCHAR(255)
        $this->forge->addColumn('tbl_accessright', [
            'menu_ids' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'department', 
            ],
        ]);
    }
}
