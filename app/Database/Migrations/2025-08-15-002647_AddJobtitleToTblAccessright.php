<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddJobtitleToTblAccessright extends Migration
{
    public function up()
    {
        $fields = [
            'jobtitle' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                // Hapus baris 'after' jika tidak perlu mengatur posisi kolom
                'after'      => 'menu_ids', // sesuaikan dengan kolom yang ada
            ],
        ];

        $this->forge->addColumn('tbl_accessright', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_accessright', 'jobtitle');
    }
}
