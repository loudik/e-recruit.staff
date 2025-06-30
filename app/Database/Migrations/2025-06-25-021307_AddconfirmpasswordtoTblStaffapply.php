<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddconfirmpasswordtoTblStaffapply extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_staffapply', [
            'confirm_password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'password' // sesuaikan letaknya
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_staffapply', 'confirmpassword');
    }
}
