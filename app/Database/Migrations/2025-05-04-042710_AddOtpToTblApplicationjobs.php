<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddOtpToTblApplicationjobs extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_applicationjobs', [
            'otp' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
                'after'      => 'email' 
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_applicationjobs', 'otp');
    }
}
