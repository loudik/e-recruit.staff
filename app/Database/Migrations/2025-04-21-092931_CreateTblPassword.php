<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblPassword extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'idemployee'     => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'password'  => ['type' => 'TEXT', 'null' => true],
            'isdeleted' => ['type' => 'SMALLINT', 'constraint' => 3, 'default' => 0],
            'iby'       => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'idt'       => ['type' => 'DATETIME', 'null' => true],
            'uby'       => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'udt'       => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true); // primary key
        $this->forge->createTable('tbl_password');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_password');
    }
}
