<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDisplaynameEmailToTblAccessright extends Migration
{
    public function up()
{
    // Tambahkan display_name lebih dulu
    $this->forge->addColumn('tbl_accessright', [
        'display_name' => [
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => true,
            'after'      => 'microsoft_id' // Hanya ini yang pakai 'after'
        ]
    ]);

    // Baru tambahkan email setelahnya
    $this->forge->addColumn('tbl_accessright', [
        'email' => [
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => true,
            'after'      => 'display_name'
        ]
    ]);
}

public function down()
{
    $this->forge->dropColumn('tbl_accessright', ['email']);
    $this->forge->dropColumn('tbl_accessright', ['display_name']);
}

}
