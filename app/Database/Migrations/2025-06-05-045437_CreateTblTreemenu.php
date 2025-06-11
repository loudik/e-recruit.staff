<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblTreemenu extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'menuname' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'menuurl' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'parent_id' => [
                'type'    => 'INT',
                'default' => 0,
            ],
            'menuicon' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'sort_order' => [
                'type'    => 'INT',
                'default' => 0,
            ],
            'isactive' => [
                'type'    => 'TINYINT',
                'default' => 1,
            ],
            'isdeleted' => ['type' => 'SMALLINT', 'default' => 0],
            'iby'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'idt'       => ['type' => 'DATETIME', 'null' => true],
            'uby'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'udt'       => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('tbl_treemenu');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_treemenu');
    }
}
