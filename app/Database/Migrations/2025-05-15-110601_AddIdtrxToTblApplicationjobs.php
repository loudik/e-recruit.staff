<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIdtrxToTblApplicationjobs extends Migration
{
     public function up()
    {
        $fields = [
            'idtrx' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
                'unique'     => true,           // ⬅️ Ini membuatnya UNIQUE
                'after'      => 'id'            // ⬅️ Letakkan setelah kolom 'id'
            ],
        ];


        $this->forge->addColumn('tbl_managementjobs', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_managementjobs', 'idtrx');
    }
}
