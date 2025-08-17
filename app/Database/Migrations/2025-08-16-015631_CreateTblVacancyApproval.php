<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblVacancyApproval extends Migration
{
    protected string $table = 'tbl_vacancy_approval';

    public function up()
    {
        $this->forge->addField([
            // PK
            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            // Form utama
            'position' => ['type'=>'VARCHAR','constraint'=>200,'null'=>true],
            'date'     => ['type'=>'DATE','null'=>true],
            'answer1'  => ['type'=>'TEXT','null'=>true],
            'answer2'  => ['type'=>'TEXT','null'=>true],
            'answer3'  => ['type'=>'TEXT','null'=>true],
            'answer4'  => ['type'=>'TEXT','null'=>true],
            'answer5'  => ['type'=>'TEXT','null'=>true],
            'answer6'  => ['type'=>'TEXT','null'=>true],
            'answer7'  => ['type'=>'TEXT','null'=>true],
            'answer8'  => ['type'=>'TEXT','null'=>true],

            // Approver (yang menyetujui)
            'apvname'      => ['type'=>'VARCHAR','constraint'=>200,'null'=>true],
            'apvposition'  => ['type'=>'VARCHAR','constraint'=>150,'null'=>true],
            'apv_ms_id'    => ['type'=>'VARCHAR','constraint'=>100,'null'=>true],
            'apv_email'    => ['type'=>'VARCHAR','constraint'=>200,'null'=>true],

            // Receiver (opsional, yang menerima; bisa dipakai nanti)
            'recname'      => ['type'=>'VARCHAR','constraint'=>200,'null'=>true],
            'recposition'  => ['type'=>'VARCHAR','constraint'=>150,'null'=>true],
            'rec_ms_id'    => ['type'=>'VARCHAR','constraint'=>100,'null'=>true],
            'rec_email'    => ['type'=>'VARCHAR','constraint'=>200,'null'=>true],

            // Status & token approval
            'status'             => ['type'=>'TINYINT','constraint'=>1,'null'=>false,'default'=>0,'comment'=>'0=PENDING,1=APPROVED,2=RECEIVED'],
            'approval_token'     => ['type'=>'VARCHAR','constraint'=>128,'null'=>true],
            'approval_token_exp' => ['type'=>'DATETIME','null'=>true],

            // QR & timestamps per tahap
            'approved_at'        => ['type'=>'DATETIME','null'=>true],
            'qr_text_approved'   => ['type'=>'TEXT','null'=>true],
            'received_at'        => ['type'=>'DATETIME','null'=>true],
            'qr_text_received'   => ['type'=>'TEXT','null'=>true],

            // File lampiran (opsional) + remark (opsional)
            'file'    => ['type'=>'VARCHAR','constraint'=>255,'null'=>true],
            'remark'  => ['type'=>'TEXT','null'=>true],

            // Meta
            'idt' => ['type'=>'DATETIME','null'=>true], // created_at
            'iby' => ['type'=>'VARCHAR','constraint'=>200,'null'=>true], // created_by (UPN)
            'udt' => ['type'=>'DATETIME','null'=>true], // updated_at
            'uby' => ['type'=>'VARCHAR','constraint'=>200,'null'=>true], // updated_by
        ]);

        $this->forge->addKey('id', true);

        // Buat tabel
        $this->forge->createTable($this->table, true);

        // Index berguna
        $db = \Config\Database::connect();
        $db->query("CREATE INDEX idx_va_status_date ON {$this->table} (status, `date`)");
        $db->query("CREATE INDEX idx_va_apv_email_status ON {$this->table} (apv_email, status)");
        $db->query("CREATE INDEX idx_va_rec_email_status ON {$this->table} (rec_email, status)");
        // (opsional) validasi token cepat:
        // $db->query(\"CREATE INDEX idx_va_token ON {$this->table} (approval_token)\");
    }

    public function down()
    {
        $db = \Config\Database::connect();
        // Hapus index jika ada
        foreach (['idx_va_status_date','idx_va_apv_email_status','idx_va_rec_email_status','idx_va_token'] as $idx) {
            try { $db->query("DROP INDEX {$idx} ON {$this->table}"); } catch (\Throwable $e) {}
        }
        // Drop table
        $this->forge->dropTable($this->table, true);
    }
}
