<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblAccessright extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'role_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'menu_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'isdeleted' => [
                'type'    => 'SMALLINT',
                'default' => 0,
            ],
            'iby' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'idt' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'uby' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'udt' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('tbl_accessright');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_accessright');
    }
}
