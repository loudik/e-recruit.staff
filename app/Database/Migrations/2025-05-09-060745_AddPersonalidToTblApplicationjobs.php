<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPersonalidToTblApplicationjobs extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_applicationjobs', [
            'personalid' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'cv' 
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_applicationjobs', 'personalid');
    }
}
