<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblApplicationjobs extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'auto_increment' => true, 'unsigned' => true],
            'idjobs'           => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'fullname'         => ['type' => 'VARCHAR', 'constraint' => 100],
            'pob'              => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'dob'              => ['type' => 'DATE', 'null' => true],
            'sexo'             => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'address'          => ['type' => 'TEXT', 'null' => true],
            'phone'            => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'email'            => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'nationality'      => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'educationlevel'   => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'institution_name' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'major'            => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'graduation'       => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'gpa'              => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'skills'           => ['type' => 'TEXT', 'null' => true],
            'language'         => ['type' => 'TEXT', 'null' => true],
            'certifications'   => ['type' => 'TEXT', 'null' => true],
            'application'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'reason'           => ['type' => 'TEXT', 'null' => true],
            'dateavailable'    => ['type' => 'DATE', 'null' => true],
            'cv'               => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'photo'            => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'diploma'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'transcript'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'coverletter'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'isdeleted'        => ['type' => 'SMALLINT', 'default' => 0],
            'iby'              => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'idt'              => ['type' => 'DATETIME', 'null' => true],
            'uby'              => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'udt'              => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tbl_applicationjobs');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_applicationjobs');
    }
}
