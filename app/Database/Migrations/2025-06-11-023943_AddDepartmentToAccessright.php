<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDepartmentToAccessright extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_accessright', [
            'department' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'role_id', 
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_accessright', 'department');
    }
}
