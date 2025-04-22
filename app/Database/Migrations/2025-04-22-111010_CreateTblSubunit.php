<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblSubunit extends Migration
{
     //
     public function up()
     {
         $this->forge->addField([
             'id'           => [
                 'type'           => 'INT',
                 'auto_increment' => true,
                 'unsigned'       => true,
             ],
             'idunit'       => [
                 'type'       => 'INT',
                 'null'       => true,
             ],
             'subunitname'  => [
                 'type'       => 'VARCHAR',
                 'constraint' => 50,
                 'null'       => true,
             ],
             'subunitcode'  => [
                 'type'       => 'VARCHAR',
                 'constraint' => 50,
                 'null'       => true,
             ],
             'idunitname'   => [
                 'type'       => 'INT',
                 'null'       => true,
             ],
             'isdeleted'    => [
                 'type'       => 'SMALLINT',
                 'default'    => 0,
             ],
             'iby'          => [
                 'type'       => 'VARCHAR',
                 'constraint' => 50,
                 'null'       => true,
             ],
             'idt'          => [
                 'type'       => 'DATE',
                 'null'       => true,
             ],
             'uby'          => [
                 'type'       => 'VARCHAR',
                 'constraint' => 50,
                 'null'       => true,
             ],
             'udt'          => [
                 'type'       => 'DATE',
                 'null'       => true,
             ],
             'ddt'          => [
                 'type'       => 'DATE',
                 'null'       => true,
             ],
         ]);
         $this->forge->addKey('id', true);
         $this->forge->createTable('tbl_subunit');
     }
 
     public function down()
     {
         $this->forge->dropTable('tbl_subunit');
     }
}
