<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIdentifyColumnsToTblVacancy extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_vacancy_approval', [
            'identify_token' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
                'null'       => true,
                'after'      => 'remark', // sesuaikan
            ],
            'identify_token_expires_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after'=> 'identify_token',
            ],
            'identify_status' => [
                'type'       => 'VARCHAR',
                'constraint' => 16, // 'pending','used','expired'
                'default'    => 'pending',
                'null'       => false,
                'after'      => 'identify_token_expires_at',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_vacancy_approval', ['identify_token','identify_token_expires_at','identify_status']);
    }
}
