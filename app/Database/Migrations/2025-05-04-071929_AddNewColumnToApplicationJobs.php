<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNewColumnToApplicationJobs extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_applicationjobs', [
            'authcount' => [
                'type'       => 'smallint',
                'constraint' => 3,
                'default'    => 0,
                'after'      => 'otp',
                'null'       => true,
            ],
            'trxid' => [
                'type'       => 'varchar',
                'constraint' => 15,
                'after'      => 'id',
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_applicationjobs', 'authcount');
        $this->forge->dropColumn('tbl_applicationjobs', 'trxid');
    }
}
