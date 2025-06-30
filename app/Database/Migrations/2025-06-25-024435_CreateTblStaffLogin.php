<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblStaffLogin extends Migration
{
     public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'username'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'password'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'fullname'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'confirm_password' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'isdeleted'  => ['type' => 'TINYINT', 'default' => 0],
            'isstatus'   => ['type' => 'TINYINT', 'default' => 1],
            'idt'        => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('tbl_stafflogin');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_stafflogin');
    }
}
