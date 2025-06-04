<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblGroup extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
                'unsigned'       => true,
            ],
            'groupname' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'remark' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'iby' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
            ],
            'idt' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'uby' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
            ],
            'udt' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'isdeleted' => [
                'type'       => 'SMALLINT',
                'constraint' => 3,
                'default'    => 0,
            ],
        ]);

        $this->forge->addKey('id', true); // Primary key
        $this->forge->createTable('tbl_group');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_group');
    }
}
