<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIdGroupToTblUnit extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_unit', [
            'idgroup' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'unsigned'   => true,
                'after'      => 'id', 
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_unit', 'idgroup');
    }
}
