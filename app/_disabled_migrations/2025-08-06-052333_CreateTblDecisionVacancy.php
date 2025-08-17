<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblDecisionVacancy extends Migration
{
     public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'answer1'       => ['type' => 'TEXT', 'null' => true],
            'answer2'       => ['type' => 'TEXT', 'null' => true],
            'answer3'       => ['type' => 'TEXT', 'null' => true],
            'answer4'       => ['type' => 'TEXT', 'null' => true],
            'answer5'       => ['type' => 'TEXT', 'null' => true],
            'answer6'       => ['type' => 'TEXT', 'null' => true],
            'answer7'       => ['type' => 'TEXT', 'null' => true],
            'answer8'       => ['type' => 'TEXT', 'null' => true],
            'position'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'date'          => ['type' => 'DATE'],
            'apvname'       => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'apvposition'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'recname'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'recposition'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'remark'        => ['type' => 'TEXT', 'null' => true],
            'status'        => ['type' => 'SMALLINT', 'constraint' => 6, 'default' => 0],
            'isdeleted'     => ['type' => 'SMALLINT', 'constraint' => 3, 'default' => 0],
            'idt'           => ['type' => 'DATETIME', 'null' => true],
            'iby'           => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'udt'           => ['type' => 'DATETIME', 'null' => true],
            'uby'           => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('tbl_decisionvacancy');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_decisionvacancy');
    }
}
