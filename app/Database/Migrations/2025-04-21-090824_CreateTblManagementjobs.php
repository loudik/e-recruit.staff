<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblManagementjobs extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'auto_increment' => true, 'unsigned' => true],
            'idunit'        => ['type' => 'INT', 'null' => false],
            'jobs'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'category'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'experiences'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'type'          => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'level'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'jobdescription'=> ['type' => 'TEXT', 'null' => true],
            'applicants'    => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'applydate'     => ['type' => 'DATETIME', 'null' => true],
            'dateexpire'    => ['type' => 'DATETIME', 'null' => false],
            'loc'           => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'status'        => ['type' => 'SMALLINT', 'default' => 0],
            'remark'        => ['type' => 'TEXT', 'null' => true],
            'isdeleted'     => ['type' => 'SMALLINT', 'default' => 0],
            'iby'           => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'idt'           => ['type' => 'DATETIME', 'null' => false],
            'uby'           => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'udt'           => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true); // Primary Key
        $this->forge->createTable('tbl_managementjobs');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_managementjobs');
    }
}
