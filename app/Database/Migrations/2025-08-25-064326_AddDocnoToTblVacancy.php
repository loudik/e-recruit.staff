<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDocnoToTblVacancy extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_vacancy_approval', [
            'doc_no'   => [
                'type'=>'VARCHAR',
                'constraint'=>100,
                'null'=>true,
                 'after'      => 'remark', 
                ]
        ]);
    }
    public function down()
    {
        $this->forge->dropColumn('tbl_vacancy_approval', 'doc_no');
    }

}
