<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTblAccessrightAddDepartmentAndMenuIdsToText extends Migration
{
    protected string $table = 'tbl_accessright';

    public function up()
    {
        // Pastikan kolom department ada
        if (! $this->db->fieldExists('department', $this->table)) {
            $this->forge->addColumn($this->table, [
                'department' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 150,
                    'null'       => true,
                ],
            ]);
        }

        // Ubah/ Tambah menu_ids menjadi TEXT
        if ($this->db->fieldExists('menu_ids', $this->table)) {
            $this->forge->modifyColumn($this->table, [
                'menu_ids' => [
                    'name' => 'menu_ids',
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
            // taruh setelah department jika tersedia
            if ($this->db->fieldExists('department', $this->table)) {
                $field['menu_ids']['after'] = 'department';
            }
            $this->forge->addColumn($this->table, $field);
        }
    }

    public function down()
    {
        // Kembalikan menu_ids ke VARCHAR(255)
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
        // Tidak drop department agar aman (bisa ditambahkan jika mau).
    }
}
