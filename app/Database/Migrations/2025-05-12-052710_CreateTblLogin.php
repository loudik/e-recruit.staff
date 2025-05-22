<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblLogin extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'idemployee' => [
                'type' => 'INT',
                'null' => false,
            ],
            'user_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'password_hash' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'isdeleted' => [
                'type'    => 'SMALLINT',
                'default' => 0,
            ],
            'iby' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'idt' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'uby' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'udt' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true); // Primary Key
        $this->forge->createTable('tbl_login');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_login');
    }

}
