<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTblAccessrightMenuIdsToText extends Migration
{
    protected string $table = 'tbl_accessright';

    public function up()
    {
        if ($this->db->fieldExists('menu_ids', $this->table)) {
            $this->forge->modifyColumn($this->table, [
                'menu_ids' => [
                    'name' => 'menu_ids', // eksplisit
                    'type' => 'TEXT',
                    'null' => true,
                ],
            ]);
        } else {
            $field = [
                'menu_ids' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
            ];
            // kalau butuh posisi:
            // if ($this->db->fieldExists('department', $this->table)) {
            //     $field['menu_ids']['after'] = 'department';
            // }
            $this->forge->addColumn($this->table, $field);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('menu_ids', $this->table)) {
            $this->forge->modifyColumn($this->table, [
                'menu_ids' => [
                    'name'       => 'menu_ids',
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                ],
            ]);
        }
    }
}
