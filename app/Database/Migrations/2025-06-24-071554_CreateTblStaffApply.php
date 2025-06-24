<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblStaffApply extends Migration
{
     public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'auto_increment' => true],
            'trxid'           => ['type' => 'VARCHAR', 'constraint' => 100],
            'idjobs'          => ['type' => 'INT', 'null' => true],
            'fullname'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'username'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'password'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'pob'             => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'dob'             => ['type' => 'DATE', 'null' => true],
            'sexo'            => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'address'         => ['type' => 'TEXT', 'null' => true],
            'phone'           => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'email'           => ['type' => 'VARCHAR', 'constraint' => 100],
            'otp'             => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'authcount'       => ['type' => 'INT', 'default' => 0],
            'nationality'     => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'educationlevel'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'institution_name'=> ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'major'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'graduation'      => ['type' => 'YEAR', 'null' => true],
            'gpa'             => ['type' => 'DECIMAL', 'constraint' => '3,2', 'null' => true],
            'skills'          => ['type' => 'TEXT', 'null' => true],
            'language'        => ['type' => 'TEXT', 'null' => true],
            'certifications'  => ['type' => 'TEXT', 'null' => true],
            'application'     => ['type' => 'TEXT', 'null' => true],
            'reason'          => ['type' => 'TEXT', 'null' => true],
            'dateavailable'   => ['type' => 'DATE', 'null' => true],
            'cv'              => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'personalid'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'photo'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'diploma'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'transcript'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'coverletter'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'isdeleted'       => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'isstatus'        => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'iby'             => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'idt'             => ['type' => 'DATETIME', 'null' => true],
            'uby'             => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'udt'             => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('tbl_staffapply');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_staffapply');
    }
}
