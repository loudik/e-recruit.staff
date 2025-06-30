<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLoginIdToStaffApply extends Migration
{
    public function up()
{
    $this->forge->addColumn('tbl_staffapply', [
        'login_id' => [
            'type' => 'INT',
            'null' => true,
            'after' => 'id'
        ]
    ]);
}

public function down()
{
    $this->forge->dropColumn('tbl_staffapply', 'login_id');
}

}
