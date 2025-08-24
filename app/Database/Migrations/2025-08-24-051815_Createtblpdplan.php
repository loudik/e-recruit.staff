<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblVacancyPd extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idpd' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            // Relasi ke vacancy approval (tanpa FK, join di logic)
            'idvaca' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>false],

            // Metadata dokumen
            'doc_no'   => ['type'=>'VARCHAR','constraint'=>100,'null'=>true],
            'doc_date' => ['type'=>'DATE','null'=>true],

            // Identitas posisi
            'position_title'      => ['type'=>'VARCHAR','constraint'=>100,'null'=>false],
            'unit_name'           => ['type'=>'VARCHAR','constraint'=>150,'null'=>true],
            'subunit_name'        => ['type'=>'VARCHAR','constraint'=>150,'null'=>true],
            'job_grade'           => ['type'=>'VARCHAR','constraint'=>50,'null'=>true],
            'employment_type'     => ['type'=>'VARCHAR','constraint'=>50,'null'=>true], // Permanent/Contract/Intern
            'location'            => ['type'=>'VARCHAR','constraint'=>150,'null'=>true],
            'supervisor_name'     => ['type'=>'VARCHAR','constraint'=>150,'null'=>true],
            'supervisor_position' => ['type'=>'VARCHAR','constraint'=>150,'null'=>true],

            // Konten PD
            'job_purpose'          => ['type'=>'TEXT','null'=>true],
            'key_responsibilities' => ['type'=>'LONGTEXT','null'=>true],
            'education'            => ['type'=>'TEXT','null'=>true],
            'experience'           => ['type'=>'TEXT','null'=>true],
            'skills'               => ['type'=>'TEXT','null'=>true],
            'competencies'         => ['type'=>'TEXT','null'=>true],
            'tools'                => ['type'=>'TEXT','null'=>true],
            'work_conditions'      => ['type'=>'TEXT','null'=>true],

            // Kompensasi (opsional)
            'currency'   => ['type'=>'VARCHAR','constraint'=>10,'null'=>true,'default'=>'USD'],
            'salary_min' => ['type'=>'DECIMAL','constraint'=>'15,2','null'=>true],
            'salary_max' => ['type'=>'DECIMAL','constraint'=>'15,2','null'=>true],

            // Status & file PDF
            'status'    => ['type'=>'SMALLINT','default'=>1], // 1=draft, 2=final
            'isdeleted' => ['type'=>'SMALLINT','default'=>0],
            'pdf_path'  => ['type'=>'VARCHAR','constraint'=>255,'null'=>true],

            // Audit (rapi & tidak duplikat)
            'iby' => ['type'=>'VARCHAR','constraint'=>120,'null'=>true], // inserted by
            'idt' => ['type'=>'DATETIME','null'=>true],                  // inserted at
            'uby' => ['type'=>'VARCHAR','constraint'=>120,'null'=>true], // updated by
            'udt' => ['type'=>'DATETIME','null'=>true],                  // updated at

            'approved_by' => ['type'=>'VARCHAR','constraint'=>120,'null'=>true],
            'approved_at' => ['type'=>'DATETIME','null'=>true],
        ]);

        $this->forge->addKey('idpd', true);
        $this->forge->addKey('idvaca');          // untuk JOIN cepat
        $this->forge->addKey('position_title');
        $this->forge->addKey('status');

        $this->forge->createTable('tbl_vacancy_pd', true);
    }

    public function down()
    {
        $this->forge->dropTable('tbl_vacancy_pd', true);
    }
}
