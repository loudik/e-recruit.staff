<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateAccessrightMicrosoftId extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_accessright', [
            'microsoft_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'id', 
            ],
        ]);

        // Hapus kolom user_id jika ada
        if ($this->db->fieldExists('user_id', 'tbl_accessright')) {
            $this->forge->dropColumn('tbl_accessright', 'user_id');
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('microsoft_id', 'tbl_accessright')) {
            $this->forge->dropColumn('tbl_accessright', 'microsoft_id');
        }

        // Tambahkan kembali user_id
        $this->forge->addColumn('tbl_accessright', [
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'after'      => 'id', // sesuaikan posisi awal
            ],
        ]);
    }
}
