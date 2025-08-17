<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIndexesOnTblDecisionvacancy extends Migration
{
    protected string $table = 'tbl_decisionvacancy';

    public function up()
    {
        $db = \Config\Database::connect();

        $createIfMissing = function (string $name, string $cols) use ($db) {
            $sql = "SELECT 1 FROM INFORMATION_SCHEMA.STATISTICS
                    WHERE TABLE_SCHEMA = DATABASE()
                      AND TABLE_NAME   = ?
                      AND INDEX_NAME   = ?
                    LIMIT 1";
            $exists = (bool) $db->query($sql, [$this->table, $name])->getFirstRow();
            if (!$exists) {
                $db->query("CREATE INDEX {$name} ON {$this->table} ({$cols})");
            }
        };

        // Index yang dibutuhkan
        $createIfMissing('idx_decision_apv', 'apv_email');
        $createIfMissing('idx_decision_rec', 'rec_email');
        // kalau mau cepat untuk token:
        // $createIfMissing('idx_decision_token', 'approval_token');
    }

    public function down()
    {
        $db = \Config\Database::connect();

        $dropIfExists = function (string $name) use ($db) {
            $sql = "SELECT 1 FROM INFORMATION_SCHEMA.STATISTICS
                    WHERE TABLE_SCHEMA = DATABASE()
                      AND TABLE_NAME   = ?
                      AND INDEX_NAME   = ?
                    LIMIT 1";
            $exists = (bool) $db->query($sql, [$this->table, $name])->getFirstRow();
            if ($exists) {
                $db->query("DROP INDEX {$name} ON {$this->table}");
            }
        };

        $dropIfExists('idx_decision_apv');
        $dropIfExists('idx_decision_rec');
        // $dropIfExists('idx_decision_token');
    }
}
