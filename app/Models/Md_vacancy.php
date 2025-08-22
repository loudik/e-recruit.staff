<?php
namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Md_vacancy extends Model
{
    protected $table      = 'tbl_vacancy_approval';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'position','date',
        'answer1','answer2','answer3','answer4','answer5','answer6','answer7','answer8',
        'apvname','apvposition','apv_ms_id','apv_email',
        'recname','recposition','rec_ms_id','rec_email',
        'status','approval_token','approval_token_exp',
        'approved_at','qr_text_approved','receive_token','receive_token_exp',
        'req_name','req_email','req_jobtitle','req_ms_id',
        'received_at','qr_text_received',
        'file','remark',
        'idt','iby','udt','uby'
    ];

    /**
     * Buat submission awal (status = PENDING)
     * @param array $payload: position,date,answers[],approver[],submitter_upn
     * @return array{id:int,token:string}
     */
    public function createSubmission(array $payload): array
    {
        $position = trim($payload['position'] ?? '');
        $date     = trim($payload['date'] ?? '');
        $ans      = $payload['answers']  ?? [];
        $appr     = $payload['approver'] ?? [];
        $rec      = $payload['receiver'] ?? [];
        $iby      = (string) ($payload['submitter_upn'] ?? '');

        if ($position === '' || $date === '' || empty($appr['ms_id']) || empty($rec['ms_id'])) {
            throw new \InvalidArgumentException('Position, Date, dan Approver wajib diisi');
        }

        $now   = Time::now()->toDateTimeString();
        $token = bin2hex(random_bytes(16));
        $exp   = Time::now()->addHours(48)->toDateTimeString();

        $row = [
            'position' => $position,
            'date'     => $date,

            'answer1' => $ans['answer1'] ?? null,
            'answer2' => $ans['answer2'] ?? null,
            'answer3' => $ans['answer3'] ?? null,
            'answer4' => $ans['answer4'] ?? null,
            'answer5' => $ans['answer5'] ?? null,
            'answer6' => $ans['answer6'] ?? null,
            'answer7' => $ans['answer7'] ?? null,
            'answer8' => $ans['answer8'] ?? null,

            'apvname'     => $appr['name']     ?? null,
            'apvposition' => $appr['jobTitle'] ?? null,
            'apv_ms_id'   => $appr['ms_id']    ?? null,
            'apv_email'   => $appr['email']    ?? null,

            'recname'     => $rec['name']     ?? null,
            'recposition' => $rec['jobTitle'] ?? null,
            'rec_ms_id'   => $rec['ms_id']    ?? null,
            'rec_email'   => $rec['email']    ?: null,

            'req_name'     => $payload['requester']['name']     ?? null,
            'req_email'    => $payload['requester']['email']    ?? null,
            'req_jobtitle' => $payload['requester']['jobTitle'] ?? null,
            'req_ms_id'    => $payload['requester']['ms_id']    ?? null,


            'status'             => 0, // PENDING
            'approval_token'     => $token,
            'approval_token_exp' => $exp,

            'idt' => $now,
            'iby' => $iby,
        ];

        if (! $this->insert($row, true)) {
            throw new \RuntimeException('DB insert failed: '.json_encode($this->errors() ?? []));
        }

        return ['id' => $this->getInsertID(), 'token' => $token];
    }

    public function getNotifyHRDS(): array
    {
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $builder->orderBy('idt', 'DESC');

        $q = $builder->get();
        $rows = $q->getResultArray();
        foreach ($rows as &$r) {
            $r['approved_at'] = $r['approved_at'] ?? null;
            $r['received_at'] = $r['received_at'] ?? null;
        }
        return $rows;
    }
}
