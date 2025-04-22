<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblAccessibility extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'auto_increment' => true, 'unsigned' => true],
            'idunit'       => ['type' => 'INT', 'null' => true],
            'idsubunit'    => ['type' => 'INT', 'null' => true],
            'idemployee'   => ['type' => 'INT', 'null' => true],
            'accessibility'=> ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'menu'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'header'       => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'isdeleted'    => ['type' => 'SMALLINT', 'default' => 0],
            'iby'          => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'idt'          => ['type' => 'DATE', 'null' => true],
            'uby'          => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'udt'          => ['type' => 'DATE', 'null' => true],
            'ddt'          => ['type' => 'DATE', 'null' => true],
        ]);

        $this->forge->addKey('id', true); // primary key
        $this->forge->createTable('tbl_accessibility');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_accessibility');
    }
}
