<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateMenuIdToText extends Migration
{
    protected string $table = 'tbl_accessright'; // pastikan ejaannya benar

    public function up()
    {
        // Kalau sudah ada, ubah tipe kolom (lebih aman daripada drop supaya data tidak hilang)
        if ($this->db->fieldExists('menu_ids', $this->table)) {
            $this->forge->modifyColumn($this->table, [
                'menu_ids' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
            ]);
            return;
        }

        // Kalau belum ada, tambahkan — taruh AFTER department hanya kalau memang ada
        $field = [
            'menu_ids' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ];
        if ($this->db->fieldExists('department', $this->table)) {
            $field['menu_ids']['after'] = 'department';
        }

        $this->forge->addColumn($this->table, $field);
    }

    public function down()
    {
        // Kembalikan ke VARCHAR(255)
        if ($this->db->fieldExists('menu_ids', $this->table)) {
            $field = [
                'menu_ids' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                ],
            ];
            if ($this->db->fieldExists('department', $this->table)) {
                $field['menu_ids']['after'] = 'department';
            }
            $this->forge->modifyColumn($this->table, $field);
        }
    }
}
