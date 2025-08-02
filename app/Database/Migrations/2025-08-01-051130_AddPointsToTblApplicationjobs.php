<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPointsToTblApplicationjobs extends Migration
{
    public function up()
    {
        $fields = [
            'totalpoin' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
                'after'      => 'isdeleted'
            ],
            'writepoint' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
                'after'      => 'totalpoin'
            ],
            'interviewpoint' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
                'after'      => 'writepoint'
            ],
            'reviewpoint' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
                'after'      => 'interviewpoint'
            ],
        ];

        $this->forge->addColumn('tbl_applicationjobs', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_applicationjobs', ['totalpoin', 'writepoint', 'interviewpoint', 'reviewpoint']);
    }
}
