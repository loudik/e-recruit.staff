<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusToTblApplicationjobs extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_applicationjobs', [
            'isstatus' => [
                'constraint' => 10,
                'null'       => true,
                'after'      => 'isdeleted' ,
                'type' => 'SMALLINT',
                'default' => 0
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_applicationjobs', 'isstatus');
    }
}
