<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddrequestToVacancy extends Migration
{
    public function up()
    {
        $fields = [
            'req_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => true,
                'after'      => 'position',   // berlaku hanya di MySQL
            ],
            'req_email' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => true,
                'after'      => 'req_name',
            ],
            'req_jobtitle' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => true,
                'after'      => 'req_email',
            ],
            'req_ms_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'req_jobtitle',
            ],
        ];

        $this->forge->addColumn('tbl_vacancy_approval', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_vacancy_approval', ['req_name','req_email','req_jobtitle','req_ms_id']);
    }
}
