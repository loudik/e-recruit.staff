<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddReceiveTokenToVacancy extends Migration
{
     public function up()
    {
        $this->forge->addColumn('tbl_vacancy_approval', [
            'receive_token' => [
                'type'       => 'VARCHAR',
                'constraint' => 128,
                'null'       => true,
                'after'      => 'approval_token',
            ],
            'receive_token_exp' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'receive_token',
            ],
        ]);

        // Index untuk lookup token
        $this->db->query('CREATE INDEX idx_vacancy_receive_token ON tbl_vacancy_approval (receive_token)');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE tbl_vacancy_approval DROP INDEX idx_vacancy_receive_token');
        $this->forge->dropColumn('tbl_vacancy_approval', ['receive_token', 'receive_token_exp']);
    }
}
