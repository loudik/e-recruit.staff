<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsstatusToTblAccessright extends Migration
{
    public function up()
{
    $this->forge->addColumn('tbl_accessright', [
        'isstatus' => [
            'type'       => 'SMALLINT',
            'constraint' => 6,
            'default'    => 0,
            'after'      => 'isdeleted', // opsional
        ]
    ]);
}

public function down()
{
    $this->forge->dropColumn('tbl_accessright', 'isstatus');
}

}
