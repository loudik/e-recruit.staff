<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAuthColumnToTblStafflogin extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_stafflogin', [
            'auth' => [
                'type'       => 'TINYINT',
                'null'    => false,
                'after'      => 'password', // opsional, untuk posisi
                'comment'    => '0 = manual, 1 = google',
            ],
        ]);
    }


    public function down()
    {
        $this->forge->dropColumn('tbl_stafflogin', 'auth');
    }
}
