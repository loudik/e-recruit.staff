<?php

namespace App\Controllers;
use App\Models\Md_adminpanel;
use App\Models\Md_administrator;
use App\Models\Md_vacancy;
use CodeIgniter\I18n\Time;

class Admin extends BaseController
{
    protected $Md_adminpanel; 

    protected $Md_administrator;
    protected $Md_vacancy;
    protected string $signKey;
    private array $lastMailError = [];
    public function __construct()
    {
        $this->Md_adminpanel = new Md_adminpanel();
        $this->Md_administrator = new Md_administrator();
        $this->Md_vacancy = new Md_vacancy();
        $this->signKey = (string)(env('APP_SIGNATURE_KEY') ?: env('app.signatureKey') ?: 'CHANGE_ME_SECRET');
        
    }


    #########################START PD PLAN#########################

    // app/Controllers/Admin.php (atau sesuai file kamu)
    public function fn_getnotifyhrds()
    {
        $microsoftId = session()->get('microsoft_id');
        $access = $this->Md_administrator->getAccessByMicrosoftId($microsoftId);
        if (!$access) {
            return $this->response->setStatusCode(403)->setBody("Data tidak ditemukan untuk Microsoft ID: {$microsoftId}");
        }

        // aman saat menu_ids kosong
        $menuIdsRaw    = (string)($access['menu_ids'] ?? '');
        $selectedMenus = $menuIdsRaw === '' ? [] : array_map('intval', explode(',', $menuIdsRaw));

        $this->data['menus']         = $this->Md_administrator->getAllMenus();
        $this->data['selectedMenus'] = $selectedMenus;
        $this->data['access']        = $access;
        $this->data['users']         = [];

        $this->data['title']         = 'Notify HRDS'; // jangan set 2x

        return view('admin/vw_notifyhrds', $this->data);
    }

    public function fn_loadnotifyhrds()
    {

        $microsoftId = session()->get('microsoft_id');
        $access = $this->Md_administrator->getAccessByMicrosoftId($microsoftId);
        if (!$access) {
            return $this->response->setJSON(['status' => false, 'message' => 'Access not found']);
        }


        $menuIdsRaw    = (string)($access['menu_ids'] ?? '');
        $selectedMenus = $menuIdsRaw === '' ? [] : array_map('intval', explode(',', $menuIdsRaw));

        $this->data['menus']         = $this->Md_administrator->getAllMenus();
        $this->data['selectedMenus'] = $selectedMenus;
        $this->data['access']        = $access;
        $this->data['users']         = [];
        $data = $this->Md_vacancy->getNotifyHRDS();

        return $this->response->setJSON([
            'status'  => !empty($data),
            'data'    => $data ?? [],
            'message' => empty($data) ? 'No data found' : null,
        ]);
    }


    //================================== START VACANCY==============================

    public function fn_getvacancy($microsoftId = null)
    {
        $microsoftId = session()->get('microsoft_id');
        $access = $this->Md_administrator->getAccessByMicrosoftId($microsoftId);
        if (!$access) {
            echo "Data tidak ditemukan untuk Microsoft ID: $microsoftId"; 
            exit;
        }
        $selectedMenus = array_map('intval', explode(',', $access['menu_ids'] ?? ''));

        $this->data['menus']         = $this->Md_administrator->getAllMenus();
        $this->data['selectedMenus'] = $selectedMenus;
        $this->data['access']        = $access;
        $this->data['users'] = [];

        $this->data['title'] = 'Vacancy';
        return view('admin/vw_identifyvac', $this->data);
    }


    public function fn_submitvacancyform()
    {
        $body = $this->request->getJSON(true) ?: $this->request->getPost();
        if (!$body) {
            return $this->response->setStatusCode(400)->setJSON(['ok'=>false,'message'=>'Empty payload']);
        }

        $position = trim($body['position'] ?? '');
        $dateRaw  = trim($body['date'] ?? '');
        $ans      = $body['answers'] ?? [];
        $appr     = $body['approver'] ?? [];
        $rec      = $body['receiver'] ?? [];

        // Normalisasi tanggal
        $date = '';
        if ($dateRaw !== '') {
            try { $date = (new \DateTime($dateRaw))->format('Y-m-d'); } catch (\Throwable $e) {}
        }

        if ($position === '' || $date === '' || empty($appr['ms_id']) || empty($rec['ms_id'])) {
            return $this->response->setStatusCode(422)->setJSON([
                'ok'=>false,
                'message'=>'Position, Date, and Approve are required'
            ]);
        }

        // Email approver
        $apprEmail = trim($appr['email'] ?? '');
        if ($apprEmail === '' || !filter_var($apprEmail, FILTER_VALIDATE_EMAIL)) {
            $apprEmail = (string) ($this->resolveUserEmailById($appr['ms_id']) ?: '');
        }
        if ($apprEmail === '') {
            return $this->response->setStatusCode(422)->setJSON([
                'ok'=>false,
                'message'=>'Email approver tidak ditemukan'
            ]);
        }

        $reqName  = (string) (session('name')       ?: '');
        $reqMail  = (string) (session('email')      ?: '');
        $reqTitle = (string) (session('jobtitle')   ?: '');
        $reqMsId  = (string) (session('microsoft_id') ?: '');
        // (opsional: validasi minimal)
        if ($reqName === '' || $reqMail === '') {
            return $this->response->setStatusCode(401)->setJSON([
                'ok'=>false,'message'=>'Session requester tidak valid. Silakan login ulang.'
            ]);
        }

        try {
            $result = $this->Md_vacancy->createSubmission([
                'position' => $position,
                'date'     => $date,
                'answers'  => $ans,
                'approver' => [
                    'name'     => $appr['name']     ?? null,
                    'jobTitle' => $appr['jobTitle'] ?? null,
                    'ms_id'    => $appr['ms_id']    ?? null,
                    'email'    => $apprEmail        ?: null,
                ],
                'receiver' => [
                    'name'     => $rec['name']     ?? null,
                    'jobTitle' => $rec['jobTitle'] ?? null,
                    'ms_id'    => $rec['ms_id']    ?? null,
                    'email'    => $rec['email']    ?: null,
                ],
                'requester' => [
                    'name'     => $reqName,
                    'email'    => $reqMail,
                    'jobTitle' => $reqTitle,
                    'ms_id'    => $reqMsId,
                ],
                'submitter_upn' => (string) (session('microsoft_upn') ?: session('microsoft_id')),
            ]);
        } catch (\InvalidArgumentException $e) {
            return $this->response->setStatusCode(422)->setJSON(['ok'=>false,'message'=>$e->getMessage()]);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)->setJSON(['ok'=>false,'message'=>$e->getMessage()]);
        }

        $id    = (int) $result['id'];
        $token = (string) $result['token'];

        log_message('info', 'Vacancy created: {id} with token {token}', ['id'=>$id, 'token'=>$token]);

        // ✅ Bangun URL approve sesuai route yang ada
        $query = http_build_query(['doc' => $id, 'token' => $token], '', '&', PHP_QUERY_RFC3986);
        $approveUrl = url_to('vacancy-approve') . '?' . $query;

        $submitter = (string) (session('microsoft_upn') ?: '');
        $sent = $this->sendApprovalMailDelegated($approveUrl, (string)$apprEmail, $position, $submitter ?: null);

        $resp = [
            'ok'        => true,
            'id'        => $id,
            'emailSent' => (bool) $sent,
        ];
        if (getenv('CI_ENVIRONMENT') === 'development') {
            $resp['approveUrl'] = $approveUrl;
            $resp['to']         = $apprEmail;
            $resp['from']       = $submitter;
            if (!$sent) {
                $resp['mailError'] = $this->lastMailError;
            }
        }

        return $this->response->setJSON($resp);
    }

    private function sendApprovalMailDelegated(string $approveUrl, string $toUPN, string $title, ?string $ccUPN = null): bool
    {
        try {
            if (!$toUPN) {
                log_message('error', 'sendApprovalMail: missing recipient');
                return false;
            }

            $token = (string) session('microsoft_token');
            if (!$token) {
                log_message('error', 'sendApprovalMail: no microsoft_token in session');
                return false;
            }

            // Konten email
            $safeTitle = htmlspecialchars((string) $title, ENT_QUOTES, 'UTF-8');
            $safeUrl   = filter_var($approveUrl, FILTER_SANITIZE_URL);

            $fmt = fn($addr) => ['emailAddress' => ['address' => $addr]];
            $message = [
                'subject' => 'Approval Needed: ' . $safeTitle,
                'body'    => [
                    'contentType' => 'HTML',
                    'content'     =>
                        '<div style="font-family:Arial,sans-serif">
                        <p>Please Approve for this Position:</p>
                        <p><strong>'.$safeTitle.'</strong></p>
                        <p>Open or Click this link: '.$safeUrl.'</p>
                        </div>'
                ],
                'toRecipients' => [$fmt($toUPN)],
            ];
            if ($ccUPN) {
                $message['ccRecipients'] = [$fmt($ccUPN)];
            }

            $payload = [
                'message' => $message,
                'saveToSentItems' => true,
            ];

            $client = \Config\Services::curlrequest();
            $res    = $client->post('https://graph.microsoft.com/v1.0/me/sendMail', [
                'headers' => [  
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type'  => 'application/json',
                ],
                'json'    => $payload,
                'http_errors' => false,
            ]);

            log_message('debug', 'sendMail response: {status} {body}', [
                'status' => $res->getStatusCode(),
                'body'   => (string) $res->getBody()
            ]);
            $status = $res->getStatusCode();
            $body   = (string) $res->getBody();

            if ($status !== 202) {
                $this->lastMailError = ['status' => $status, 'body' => $body];
                log_message('error', 'sendMail failed: {status} {body}', ['status'=>$status,'body'=>$body]);
                return false;
            }

            $this->lastMailError = [];
            return true;

        } catch (\Throwable $e) {
            $this->lastMailError = ['exception' => $e->getMessage()];
            log_message('error', 'sendMail exception: '.$e->getMessage());
            return false;
        }
    }

    public function approve()
    {
        $isPost = strtolower($this->request->getMethod()) === 'post';
        $id     = (int) ($isPost ? $this->request->getPost('doc')   : $this->request->getGet('doc'));
        $token  = (string)($isPost ? $this->request->getPost('token'): $this->request->getGet('token'));
        if (!$id || !$token) return $this->response->setStatusCode(400)->setBody('Bad request');

        $row = $this->Md_vacancy->find($id);
        if (!$row) return $this->response->setStatusCode(404)->setBody('Not found');
        if (!hash_equals((string)$row['approval_token'], $token)) return $this->response->setStatusCode(403)->setBody('Invalid token');
        if (!empty($row['approval_token_exp']) && Time::now()->isAfter(Time::parse($row['approval_token_exp']))) {
            return $this->response->setStatusCode(410)->setBody('Token expired');
        }

        if ($isPost) {
            if ((int)$row['status'] !== 0) return $this->response->setStatusCode(409)->setBody('Already handled');

            // Build signed QR verify URL
            $role = 'approved';
            $uid  = (string) ($row['apv_ms_id'] ?? '');
            if ($uid === '') return $this->response->setStatusCode(422)->setBody('Approver missing');
            $ts  = time();
            $sig = $this->sign("$id|$role|$uid|$ts", $this->signKey);
            $qr  = url_to('vacancy-signature') . '?' . http_build_query(
                    ['doc'=>$id,'role'=>$role,'uid'=>$uid,'ts'=>$ts,'sig'=>$sig],
                    '', '&', PHP_QUERY_RFC3986
                );

            $actor = (string) (session('microsoft_upn') ?: session('microsoft_id') ?: $row['apv_email'] ?: $uid);

            // Update → approved & simpan QR, (opsional) matikan token
            $this->Md_vacancy->update($id, [
                'status'           => 1,
                'approved_at'      => Time::now()->toDateTimeString(),
                'qr_text_approved' => $qr,
                'approval_token'   => null,
                'udt'              => Time::now()->toDateTimeString(),
                'uby'              => $actor,
            ]);

            $row = $this->Md_vacancy->find($id) ?: $row;

            return view('admin/vw_vacancyapprove', [
                'title'   => 'Vacancy Approved',
                'doc'     => $id,
                'token'   => null,
                'qrText'  => $qr,  // ⇒ QR akan dirender
                'data'    => $row,
                'answers' => [
                    'answer1'=>$row['answer1'] ?? '', 'answer2'=>$row['answer2'] ?? '',
                    'answer3'=>$row['answer3'] ?? '', 'answer4'=>$row['answer4'] ?? '',
                    'answer5'=>$row['answer5'] ?? '', 'answer6'=>$row['answer6'] ?? '',
                    'answer7'=>$row['answer7'] ?? '', 'answer8'=>$row['answer8'] ?? '',
                ],
                'approver' => [
                    'name'=>$row['apvname'] ?? '', 'jobTitle'=>$row['apvposition'] ?? '',
                    'ms_id'=>$row['apv_ms_id'] ?? '', 'email'=>$row['apv_email'] ?? '',
                ],
                'receiver' => [
                    'name'=>$row['recname'] ?? '', 'jobTitle'=>$row['recposition'] ?? '',
                    'ms_id'=>$row['rec_ms_id'] ?? '', 'email'=>$row['rec_email'] ?? '',
                ],
            ]);
        }

        // GET: review (tanpa QR, tampil tombol Approve)
        $qrText = ((int)$row['status'] === 1) ? (string)($row['qr_text_approved'] ?? '') : '';

        return view('admin/vw_vacancyapprove', [
            'title'   => 'Vacancy Approval',
            'doc'     => $id,
            'token'   => $token,   // dikirim balik saat POST
            'qrText'  => $qrText,  // kosong → tidak render QR
            'data'    => $row,
            'answers' => [
                'answer1'=>$row['answer1'], 'answer2'=>$row['answer2'],
                'answer3'=>$row['answer3'], 'answer4'=>$row['answer4'],
                'answer5'=>$row['answer5'], 'answer6'=>$row['answer6'],
                'answer7'=>$row['answer7'], 'answer8'=>$row['answer8'],
            ],
            'approver' => [
                'name'=>$row['apvname'], 'jobTitle'=>$row['apvposition'],
                'ms_id'=>$row['apv_ms_id'], 'email'=>$row['apv_email'],
            ],
            'receiver' => [
                'name'=>$row['recname'], 'jobTitle'=>$row['recposition'],
                'ms_id'=>$row['rec_ms_id'], 'email'=>$row['rec_email'],
            ],
        ]);
    }

    private function resolveUserEmailById(string $msId): ?string
    {
        $token = (string) session('microsoft_token');
        if (!$token || !$msId) return null;

        $client = \Config\Services::curlrequest();
        $res = $client->get('https://graph.microsoft.com/v1.0/users/'.rawurlencode($msId).'?$select=mail,userPrincipalName', [
            'headers' => [
                'Authorization'    => 'Bearer '.$token,
                'ConsistencyLevel' => 'eventual',
                'Accept'           => 'application/json',
            ],
            'http_errors' => false,
            'timeout'     => 10,
        ]);
        if ($res->getStatusCode() !== 200) return null;
        $json = json_decode((string)$res->getBody(), true) ?: [];
        return $json['mail'] ?? $json['userPrincipalName'] ?? null;
    }


    private function resolveUserEmailByIdrecuid(string $recUid): ?string
    {
        $token = (string) session('microsoft_token');
        if (!$token || !$recUid) return null;

        $client = \Config\Services::curlrequest();
        $res = $client->get('https://graph.microsoft.com/v1.0/users/'.rawurlencode($recUid).'?$select=mail,userPrincipalName', [
            'headers' => [
                'Authorization'    => 'Bearer '.$token,
                'ConsistencyLevel' => 'eventual',
                'Accept'           => 'application/json',
            ],
            'http_errors' => false,
            'timeout'     => 10,
        ]);
        if ($res->getStatusCode() !== 200) return null;
        $json = json_decode((string)$res->getBody(), true) ?: [];
        return $json['mail'] ?? $json['userPrincipalName'] ?? null;
    }


    public function fn_doreceive()
    {
        $id     = (int) $this->request->getPost('doc');
        $rtoken = (string) $this->request->getPost('rtoken');
        if (!$id || !$rtoken) return $this->response->setJSON(['ok'=>false,'msg'=>'Bad request']);

        $row = $this->Md_vacancy->find($id);
        if (!$row) return $this->response->setJSON(['ok'=>false,'msg'=>'Not found']);
        if ((int)$row['status'] < 1) return $this->response->setJSON(['ok'=>false,'msg'=>'Not approved yet']);

        if (!hash_equals((string)($row['receive_token'] ?? ''), $rtoken)) {
            return $this->response->setJSON(['ok'=>false,'msg'=>'Invalid token']);
        }
        if (!empty($row['receive_token_exp']) && Time::now()->isAfter(Time::parse($row['receive_token_exp']))) {
            return $this->response->setJSON(['ok'=>false,'msg'=>'Token expired']);
        }

        $roleR = 'received';
        $uidR  = (string)($row['rec_ms_id'] ?? '');
        if ($uidR === '') return $this->response->setJSON(['ok'=>false,'msg'=>'Receiver UID missing']);

        $tsR  = time();
        $sigR = $this->sign("{$id}|{$roleR}|{$uidR}|{$tsR}", $this->signKey);
        $qrReceived = url_to('vacancy-signature') . '?' . http_build_query([
            'doc'=>$id,'role'=>$roleR,'uid'=>$uidR,'ts'=>$tsR,'sig'=>$sigR
        ], '', '&', PHP_QUERY_RFC3986);

        // Update DB dulu
        $this->Md_vacancy->update($id, [
            'status'             => 2,
            'received_at'        => Time::now()->toDateTimeString(),
            'qr_text_received'   => $qrReceived,
            'receive_token'      => null,
            'receive_token_exp'  => null,
            'udt'                => Time::now()->toDateTimeString(),
            'uby'                => (string)(session('microsoft_upn') ?: session('microsoft_id') ?: ($row['rec_email'] ?? $uidR)),
        ]);

        log_message('info', 'Vacancy received: {id} with QR {qr}', ['id'=>$id, 'qr'=>$qrReceived]);

        return $this->response->setJSON(['ok'=>true,'qr'=>$qrReceived]);
    }

    public function receive() // GET only
    {
        $id     = (int) $this->request->getGet('doc');
        $rtoken = (string) $this->request->getGet('rtoken');
        if (!$id || $rtoken === '') return $this->response->setStatusCode(400)->setBody('Bad request');

        $row = $this->Md_vacancy->find($id);
        if (!$row) return $this->response->setStatusCode(404)->setBody('Not found');

        if (!hash_equals((string)($row['receive_token'] ?? ''), $rtoken)) {
            return $this->response->setStatusCode(403)->setBody('Invalid token');
        }
        if (!empty($row['receive_token_exp']) && Time::now()->isAfter(Time::parse($row['receive_token_exp']))) {
            return $this->response->setStatusCode(410)->setBody('Token expired');
        }

        $qrTextReceived = ((int)$row['status'] === 2) ? (string)($row['qr_text_received'] ?? '') : '';

        return view('admin/vw_vacancyreceive', [
            'title'          => 'Vacancy Receive',
            'doc'            => $id,
            'rtoken'         => $rtoken,
            'data'           => $row,
            'answers'        => [
                'answer1'=>$row['answer1'] ?? '', 'answer2'=>$row['answer2'] ?? '',
                'answer3'=>$row['answer3'] ?? '', 'answer4'=>$row['answer4'] ?? '',
                'answer5'=>$row['answer5'] ?? '', 'answer6'=>$row['answer6'] ?? '',
                'answer7'=>$row['answer7'] ?? '', 'answer8'=>$row['answer8'] ?? '',
            ],
            'approver'       => [
                'name'=>$row['apvname'] ?? '', 'jobTitle'=>$row['apvposition'] ?? '',
                'ms_id'=>$row['apv_ms_id'] ?? '', 'email'=>$row['apv_email'] ?? '',
            ],
            'receiver'       => [
                'name'=>$row['recname'] ?? '', 'jobTitle'=>$row['recposition'] ?? '',
                'ms_id'=>$row['rec_ms_id'] ?? '', 'email'=>$row['rec_email'] ?? '',
            ],
            'qrTextReceived' => $qrTextReceived,
        ]);
    }


    private function sign(string $data, string $key): string
    {
        return rtrim(strtr(base64_encode(hash_hmac('sha256', $data, $key, true)), '+/', '-_'), '=');
    }

    public function signature()
    {
        $doc  = (int) $this->request->getGet('doc');
        $role = (string) $this->request->getGet('role');
        $uid  = (string) $this->request->getGet('uid');
        $ts   = (int) $this->request->getGet('ts');
        $sig  = (string) $this->request->getGet('sig');

        if (!$doc || !$role || !$uid || !$ts || $sig === '') {
            return $this->showSigResult(false, 'Missing parameters');
        }

        $now    = time();
        $maxAge = 60 * 60 * 24 * 30; // 30 hari
        if ($ts > $now + 300 || $now - $ts > $maxAge) {
            return $this->showSigResult(false, 'Signature expired');
        }

        $row = $this->Md_vacancy->find($doc);
        if (!$row) {
            return $this->showSigResult(false, 'Document not found');
        }

        // cek role
        if ($role === 'approved') {
            $dbUid = (string) ($row['apv_ms_id'] ?? '');
        } elseif ($role === 'received') {
            $dbUid = (string) ($row['rec_ms_id'] ?? '');
        } else {
            return $this->showSigResult(false, 'Invalid role');
        }

        if ($dbUid === '' || $dbUid !== $uid) {
            return $this->showSigResult(false, 'UID mismatch');
        }

        // verifikasi HMAC
        $expected = $this->sign("{$doc}|{$role}|{$uid}|{$ts}", $this->signKey);
        if (!hash_equals($expected, $sig)) {
            return $this->showSigResult(false, 'Invalid signature');
        }

       // sukses -> siapkan data untuk view
        $approved = [
            'name'     => $row['apvname'] ?? null,
            'jobTitle' => $row['apvposition'] ?? null,
            'email'    => $row['apv_email'] ?? null,
            'time'     => $row['approved_at'] ?? null,
            'qr'       => $row['qr_text_approved'] ?? null,
        ];
        $received = [
            'name'     => $row['recname'] ?? null,
            'jobTitle' => $row['recposition'] ?? null,
            'email'    => $row['rec_email'] ?? null,
            'time'     => $row['received_at'] ?? null,
            'qr'       => $row['rec_qr'] ?? null,
        ];

        $answers = [
            'answer1' => $row['answer1'] ?? null,
            'answer2' => $row['answer2'] ?? null,
            'answer3' => $row['answer3'] ?? null,
            'answer4' => $row['answer4'] ?? null,
            'answer5' => $row['answer5'] ?? null,
            'answer6' => $row['answer6'] ?? null,
            'answer7' => $row['answer7'] ?? null,
            'answer8' => $row['answer8'] ?? null,
        ];

        $data = [
            'doc'      => $doc,
            'uid'      => $uid,
            'role'     => $role,                    // 'approved' | 'received'
            'position' => $row['position'] ?? '',
            // 'qr_text_approved' => $row['apv_qr'] ?? '',
            // 'qr_text_received' => $row['rec_qr'] ?? '',
        ];


       if ($role === 'approved') {
            $approved_status = 'verified';
            $received_status = !empty($row['received_at']) ? 'verified' : 'pending';
        } elseif ($role === 'received') {
            $approved_status = 'verified';
            $received_status = 'verified';
        } else {
            // fallback ke kondisi DB (kalau perlu)
            $approved_status = !empty($row['approved_at']) ? 'verified' : 'pending';
            $received_status = !empty($row['received_at']) ? 'verified' : 'pending';
        }

        // $approved_status = (!empty($row['approved_at']) || $role === 'approved') ? 'verified' : 'pending';
        // $received_status = (!empty($row['received_at']) || $role === 'received') ? 'verified' : 'pending';


        return $this->showSigResult(true, null, $data, $approved, $received, $answers, $approved_status, $received_status);

    }

    private function showSigResult(
        bool $ok,
        ?string $error = null,
        array $data = [],
        array $approved = [],
        array $received = [],
        array $answers = [],
        string $approved_status = 'pending',
        string $received_status = 'pending'
    ) {
        return view('admin/vw_vacancysignature', [
            'ok'               => $ok,
            'err'              => $error,
            'data'             => $data,
            'approved'         => $approved,
            'received'         => $received,
            'answers'          => $answers,
            'approved_status'  => $approved_status,  // 'verified' | 'pending'
            'received_status'  => $received_status,  // 'verified' | 'pending'
            'title'            => 'Vacancy — Signature Details',
        ]);
    }


    public function fn_doapprove()
    {
        $id    = (int) $this->request->getPost('doc');
        $token = (string) $this->request->getPost('token');
        if (!$id || !$token) return $this->response->setJSON(['ok'=>false,'msg'=>'Bad request']);

        $row = $this->Md_vacancy->find($id);
        if (!$row || (int)$row['status'] !== 0) return $this->response->setJSON(['ok'=>false,'msg'=>'Not found or already handled']);
        if (!hash_equals((string)$row['approval_token'], $token)) return $this->response->setJSON(['ok'=>false,'msg'=>'Invalid token']);

        // 1) Generate QR Approved (role=approved) → tampil di halaman ini
        $roleA = 'approved';
        $uidA  = (string) ($row['apv_ms_id'] ?? '');
        $tsA   = time();
        $sigA  = $this->sign("{$id}|{$roleA}|{$uidA}|{$tsA}", $this->signKey);
        $qrApproved = url_to('vacancy-signature') . '?' . http_build_query([
            'doc'=>$id,'role'=>$roleA,'uid'=>$uidA,'ts'=>$tsA,'sig'=>$sigA
        ], '', '&', PHP_QUERY_RFC3986);


        $this->Md_vacancy->update($id, [
            'status'             => 1,
            'approved_at'        => Time::now()->toDateTimeString(),
            'qr_text_approved'   => $qrApproved,
            'approval_token'     => null,
            'udt'                => Time::now()->toDateTimeString(),
            'uby'                => (string) (session('microsoft_upn') ?: session('microsoft_id')),
        ]);

        // 3) Siapkan link REVIEW untuk Receiver (BUKAN signature)
        try {
            $recUid   = (string) ($row['rec_ms_id'] ?? '');
            $recEmail = (string) ($row['rec_email'] ?? '');
            if ($recEmail === '' && $recUid !== '') {
                $recEmail = (string) ($this->resolveUserEmailByIdrecuid($recUid) ?: '');
            }

            if ($recUid !== '' && $recEmail !== '') {
                // token khusus receiver (rtoken) + expiry, simpan di DB
                $rtoken   = bin2hex(random_bytes(16));
                $rtokenExp= Time::now()->addDays(7)->toDateTimeString();

                $this->Md_vacancy->update($id, [
                    'receive_token'     => $rtoken,
                    'receive_token_exp' => $rtokenExp,
                    'udt'               => Time::now()->toDateTimeString(),
                ]);

                // build URL ke halaman review receiver (ada tombol Approve di sana)
                $q = http_build_query(['doc'=>$id,'rtoken'=>$rtoken], '', '&', PHP_QUERY_RFC3986);
                $receiveUrl = url_to('vacancy-receive') . '?' . $q;

                // kirim email ke Receiver
                $safePos = htmlspecialchars((string)($row['position'] ?? 'Vacancy'), ENT_QUOTES, 'UTF-8');
                $safeUrl = htmlspecialchars($receiveUrl, ENT_QUOTES, 'UTF-8');
                $html = '
                    <div style="font-family:Arial,sans-serif;font-size:14px;line-height:1.5">
                    <p><strong>Receipt Confirmation Required</strong></p>
                    <p>You are assigned as <b>Receiver</b> for:</p>
                    <p style="margin:8px 0 14px"><strong>'.$safePos.'</strong></p>
                    <p>Please review the details and confirm receipt at this link:</p>
                    <p style="word-break:break-all">'.$safeUrl.'</p>
                    </div>';

                $this->sendMailDelegated($recEmail, 'Receipt Confirmation Needed: '.$safePos, $html);
            }
        } catch (\Throwable $e) {
            log_message('error', 'send receiver review link failed: '.$e->getMessage());
        }

        // 4) respond ke FE (tampilkan QR Approved)
        return $this->response->setJSON(['ok'=>true,'qr'=>$qrApproved]);
    }



    private function sendMailDelegated(string $toUPN, string $subject, string $html, ?string $ccUPN = null): bool
    {
        try {
            if (!$toUPN) {
                log_message('error', 'sendMailDelegated: missing recipient');
                return false;
            }

            $token = (string) session('microsoft_token');
            if (!$token) {
                log_message('error', 'sendMailDelegated: no microsoft_token in session');
                return false;
            }

            $fmt = fn($addr) => ['emailAddress' => ['address' => $addr]];
            $message = [
                'subject' => $subject,
                'body'    => [
                    'contentType' => 'HTML',
                    'content'     => $html
                ],
                'toRecipients' => [$fmt($toUPN)],
            ];
            if ($ccUPN) {
                $message['ccRecipients'] = [$fmt($ccUPN)];
            }

            $payload = [
                'message' => $message,
                'saveToSentItems' => true,
            ];

            $client = \Config\Services::curlrequest();
            $res    = $client->post('https://graph.microsoft.com/v1.0/me/sendMail', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type'  => 'application/json',
                ],
                'json'    => $payload,
                'http_errors' => false,
            ]);

            log_message('debug', 'sendMailDelegated response: {status} {body}', [
                'status' => $res->getStatusCode(),
                'body'   => (string) $res->getBody()
            ]);

            if ($res->getStatusCode() !== 202) {
                $this->lastMailError = [
                    'status' => $res->getStatusCode(),
                    'body'   => (string) $res->getBody()
                ];
                log_message('error', 'sendMailDelegated failed: {status} {body}', $this->lastMailError);
                return false;
            }

            $this->lastMailError = [];
            return true;

        } catch (\Throwable $e) {
            $this->lastMailError = ['exception' => $e->getMessage()];
            log_message('error', 'sendMailDelegated exception: '.$e->getMessage());
            return false;
        }
    }

    //  ============================end Vacancy Management ============================



    ############ START ADMINISTRATOR FUNCTIONS ############
    public function fn_getadministrator($microsoftId = null)
    {
        
        $microsoftId = session()->get('microsoft_id');
        $access = $this->Md_administrator->getAccessByMicrosoftId($microsoftId);
        if (!$access) {
            echo "Data tidak ditemukan untuk Microsoft ID: $microsoftId"; exit;
        }

        $selectedMenus = array_map('intval', explode(',', $access['menu_ids'] ?? ''));

        $this->data['menus'] = $this->Md_administrator->getAllMenus();
        $this->data['selectedMenus'] = $selectedMenus;
        $this->data['access'] = $access;
        $this->data['users'] = [];

        return view('admin/vw_administrator', $this->data);
    }

    public function get_menuaccess()
    {
        $microsoftId = $this->request->getGet('microsoft_id');
        if (!$microsoftId) {
            return $this->response->setJSON(['error' => 'Microsoft ID kosong']);
        }
        $access = $this->Md_administrator->getAccessByMicrosoftId($microsoftId);
        if (!$access || empty($access['menu_ids'])) {
        log_message('debug', 'Akses tidak ditemukan untuk ID: ' . $microsoftId);
            return $this->response->setJSON(['error' => 'Access denied']);
        }
        $selectedMenus = array_map('intval', explode(',', $access['menu_ids']));
        return $this->response->setJSON(['selectedMenus' => $selectedMenus]);
    }

    public function fn_detailadministrator()
    {
        $data = $this->Md_adminpanel->fn_detailadministrator(); // ⬅️ ambil semua tanpa filter microsoft_id

        foreach ($data as $index => &$row) {
            $row['no'] = $index + 1;
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $data
        ]);
    }


    public function fn_addadministrator()
    {
        $employeeID = $this->request->getPost('employee'); // Sesuaikan dengan JS
        $department = $this->request->getPost('department');
        $menuIDs = $this->request->getPost('menuaccess');
        $displayName = $this->request->getPost('displayname');  
        $email       = $this->request->getPost('email');

        if (!$employeeID || !is_string($employeeID)) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Valid Employee ID is required.'
        ]);
        }

        if (!is_array($menuIDs) || count($menuIDs) === 0) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'At least one menu must be selected.'
            ]);
        }

    
        // Panggil model untuk simpan ke DB
        $result = $this->Md_administrator->addAdministrator($employeeID, $department, $menuIDs, $displayName,$email);


        if ($result) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Administrator added successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to add administrator.'
            ]);
        }
        
    }
    

    
    public function fn_getdashboard()
    {
        // $this->loadSidebarMenus();
        $range = $this->request->getGet('range') ?? 7;

        $this->data['title'] = 'Dashboard Admin Panel';
        $this->data['menu'] = $this->menu;
        $this->data['candidates'] = $this->Md_adminpanel->fn_getall();
        $this->data['jobs'] = $this->Md_adminpanel->fn_getjobcount();
        $this->data['applications'] = $this->Md_adminpanel->fn_getapplicationcount();
        $this->data['candidatesreject'] = $this->Md_adminpanel->fn_getcandidatereject();
        $this->data['candidateapprove'] = $this->Md_adminpanel->fn_getcandidateapprove();
        $this->data['applicationsCount'] = $this->Md_adminpanel->getApplicationsCount($range);
        $this->data['applicationsBeforeCount'] = $this->Md_adminpanel->getApplicationsBeforeCount($range);

        $growthPercent = 0;
        $isGrowthUp = false;
        if ($this->data['applicationsBeforeCount'] > 0) {
            $growthPercent = (
                ($this->data['applicationsCount'] - $this->data['applicationsBeforeCount']) /
                $this->data['applicationsBeforeCount']
            ) * 100;

            $isGrowthUp = $this->data['applicationsCount'] > $this->data['applicationsBeforeCount'];
        }

        $this->data['growthPercent'] = round($growthPercent, 1);
        $this->data['isGrowthUp'] = $isGrowthUp;
        $this->data['selectedDays'] = $range;

        return view('admin/vw_dashboard', $this->data);
    }
    public function fn_getdashboarddefault()
    {
        $range = $this->request->getGet('range') ?? 7;

        $this->data['title'] = 'Dashboard Admin Panel';
        $this->data['menu'] = $this->menu;
        $this->data['candidates'] = $this->Md_adminpanel->fn_getall();
        $this->data['jobs'] = $this->Md_adminpanel->fn_getjobcount();
        $this->data['applications'] = $this->Md_adminpanel->fn_getapplicationcount();
        $this->data['candidatesreject'] = $this->Md_adminpanel->fn_getcandidatereject();
        $this->data['candidateapprove'] = $this->Md_adminpanel->fn_getcandidateapprove();
        $this->data['applicationsCount'] = $this->Md_adminpanel->getApplicationsCount($range);
        $this->data['applicationsBeforeCount'] = $this->Md_adminpanel->getApplicationsBeforeCount($range);

        $growthPercent = 0;
        $isGrowthUp = false;

        if ($this->data['applicationsBeforeCount'] > 0) {
            $growthPercent = (
                ($this->data['applicationsCount'] - $this->data['applicationsBeforeCount']) /
                $this->data['applicationsBeforeCount']
            ) * 100;

            $isGrowthUp = $this->data['applicationsCount'] > $this->data['applicationsBeforeCount'];
        }

        $this->data['growthPercent'] = round($growthPercent, 1);
        $this->data['isGrowthUp'] = $isGrowthUp;
        $this->data['selectedDays'] = $range;

        return view('admin/vw_dashboarddefault', $this->data);
    }



    public function getApplicationChartData()
    {
        $days = $this->request->getGet('range') ?? 7;
        $rawData = $this->Md_adminpanel->getChartData($days);
        $groupedData = [];
        foreach ($rawData as $row) {
            $groupedData[$row['date']] = (int) $row['count'];
        }
        $labels = [];
        $data = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            $labels[] = date('M d', strtotime($date));
            $data[] = $groupedData[$date] ?? 0;
        }

        return $this->response->setJSON([
            'labels' => $labels,
            'data' => $data
        ]);
    }

    public function getLevelStats()
    {
        $days = $this->request->getGet('range') ?? 7;
        $results = $this->Md_adminpanel->getLevelStats($days);
        if (empty($results)) {
            $results = $this->Md_adminpanel->getLevelStats(); 
        }

        $data = [
            'labels' => [],
            'values' => [],
        ];

        foreach ($results as $row) {
            $levelLabel = ucfirst(strtolower($row['level']));
            $data['labels'][] = $levelLabel;
            $data['values'][] = (int) $row['total'];
        }

        return $this->response->setJSON($data);
    }


    public function getGenderStats()
    {
        $days = $this->request->getGet('range') ?? 7;
        $results = $this->Md_adminpanel->getGenderStats($days);
        if (empty($results)) {
            $results = $this->Md_adminpanel->getGenderStats(); 
        }

        $data = [
            'labels' => [],
            'values' => [],
        ];

        foreach ($results as $row) {
            $genderLabel = ucfirst(strtolower($row['sexo']));
            $data['labels'][] = $genderLabel;
            $data['values'][] = (int) $row['total'];
        }

        return $this->response->setJSON($data);
    }

    public function getCandidateStats()
    {
        $days = $this->request->getGet('range') ?? 7;
        $results = $this->Md_adminpanel->getCandidateTypeStats($days);
        if (empty($results)) {
            $results = $this->Md_adminpanel->getCandidateTypeStats(); 
        }

        // Siapkan data untuk chart
        $data = [
            'labels' => [],
            'values' => [],
        ];

        foreach ($results as $row) {
            $label = isset($row['type']) ? ucfirst(strtolower($row['type'])) : 'Unknown';
            $data['labels'][] = $label;
            $data['values'][] = (int) $row['total'];
        }

        return $this->response->setJSON($data);
    }


    public function fn_action()
    {
        //  $this->data['sidebarMenus'] = $this->loadSidebarMenus();
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $requestData = $this->request->getJSON(true);
        $ids = $requestData['ids'] ?? [];
        $action = $requestData['action'] ?? '';

        if (empty($ids) || !in_array($action, ['approve', 'reject', 'delete'])) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid input']);
        }

        $success = $thi->Md_adminpanel->fn_updateaction($ids, $action);

        return $this->response->setJSON([
            'status' => $success ? 'success' : 'error',
            'message' => $success ? 'Bulk action completed' : 'Failed to process action'
        ]);
    }

    ###############END ADMINISTRATOR FUNCTIONS ###############


    public function fn_getnewjobs()
    {
        
        $this->data['title'] = 'New Jobs';
        $this->data['menu'] = $this->menu;
        $this->data['group'] = $this->Md_adminpanel->fn_getgroup();
        $this->data['categories'] = [];
        
        return view('admin/vw_newjobs', $this->data);
    }


    public function getCategoriesByGroup($groupId)
    {
        $categories = $this->Md_adminpanel->fn_getcategorybygroup($groupId);
        return $this->response->setJSON($categories);
    }

    public function fn_getmanagejobs()
    {
        //  $this->data['sidebarMenus'] = $this->loadSidebarMenus();
        $this->data['title'] = 'Manage Jobs';
        $this->data['menu'] = $this->menu;
        // $this->data['jobs'] = $this->Md_adminpanel->fn_loadmanagejob();
        return view('admin/vw_managejobs', $this->data);
    }


    public function fn_getmanagedata()
    {

         $result = $this->Md_adminpanel->fn_getmanagedata();
        if (!empty($result)) {
          return $this->response->setJSON([
            'response' => 'success',
            'data' => $result
        ]);
        } else {
          return $this->response->setJSON([
            'response' => 'error',
            'message'  => 'No candidates found.'
          ]);
        }
    }



   public function updateJobStatus()
    {
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        if (!$id || $status === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request'
            ])->setStatusCode(400);
        }
        $updated = $this->Md_adminpanel->updateStatus($id, $status);

        return $this->response->setJSON([
            'success' => $updated,
            'message' => $updated ? 'Status updated successfully' : 'Gagal update status'
        ])->setStatusCode(200);
    }

    public function fn_updatestatusadmin()
    {
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        if (!$id || $status === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request'
            ])->setStatusCode(400);
        }

        $updated = $this->Md_adminpanel->fn_updatestatusadmin($id, $status);

        return $this->response->setJSON([
            'success' => $updated,
            'message' => $updated ? 'Status updated successfully' : 'Failed to update'
        ])->setStatusCode(200);
    }


     public function fn_searchjobs()
    {
        $keyword = $this->request->getGet('q') ?? '';
        $data = $this->Md_adminpanel->searchManageJobs($keyword);

        return $this->response->setJSON([
            'response' => 'success',
            'data' => $data
        ]);
    }


    public function fn_getcandidate()
    {   
        $this->data['menu'] = $this->menu;
      return view('admin/vw_candidate', $this->data);
    }

    public function getcandidate()
    {
      $candidates = $this->Md_adminpanel->fn_getcandidate();
      if (!empty($candidates)) {
        return $this->response->setJSON([
          'response' => 'success',
          'data' => $candidates
      ]);
      } else {
        return $this->response->setJSON([
          'response' => 'error',
          'message'  => 'No candidates found.'
        ]);
      }
    }

    public function fn_approvecandidate()
    {
        $id = $this->request->getPost('id');
        $totalPoint = $this->request->getPost('total_point'); 
        $result = $this->Md_adminpanel->fn_approvecandidate($id, $totalPoint);

        if ($result) {
            return $this->response->setJSON([
                'response' => 'success',
                'message'  => 'Candidate approved successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'response' => 'error',
                'message'  => 'Failed to approve candidate.'
            ]);
        }
    }

    public function fn_rejectcandidate()
    {
        $id = $this->request->getPost('id');
        $reason = $this->request->getPost('reason');

        $candidate = $this->Md_adminpanel->getCandidateById($id);
        if (!$candidate || empty($candidate['email'])) {
            return $this->response->setJSON([
                'response' => 'error',
                'message'  => 'Candidate email not found.'
            ]);
        }
        
        $result = $this->Md_adminpanel->fn_rejectcandidate($id, $reason);

        if ($result) {
            // Kirim email ke kandidat
            $emailService = \Config\Services::email();
            $emailService->setTo($candidate['email']);
            $emailService->setFrom('loudikmarkai@gmail.com', 'HR Recruitment');
            $emailService->setSubject('Application Rejection Notification');
            $emailService->setMessage(
                "Dear {$candidate['fullname']},\n\n" .
                "We regret to inform you that your application has been rejected.\n\n" .
                "Reason: {$reason}\n\n" .
                "Thank you for applying.\n\nBest regards,\nRecruitment Team"
            );

            if (!$emailService->send()) {
                log_message('error', '❌ Email gagal dikirim ke: ' . $candidate['email']);
                log_message('error', print_r($emailService->printDebugger(['headers', 'subject', 'body']), true));
            }

            return $this->response->setJSON([
                'response' => 'success',
                'message'  => 'Candidate rejected and email sent.'
            ]);
        } else {
            return $this->response->setJSON([
                'response' => 'error',
                'message'  => 'Failed to reject candidate.'
            ]);
        }
    }



    public function fn_detailcandidate()
    {
     $id = $this->request->getPost('id');
        $dataDB = $this->Md_adminpanel->getCandidateDocuments($id);
        // $candidate = $this->Md_adminpanel->getCandidateDetail($id);


        // if (!$candidate || !is_array($candidate)) {
        //     return $this->response->setJSON([
        //         'response' => 'error',
        //         'message' => 'No candidate found.',
        //         'debug' => $candidate
        //     ]);
        // }
        // if (!$files || !is_array($files)) {
        //     return $this->response->setJSON([
        //         'response' => 'error',
        //         'message' => 'No files found.',
        //         'debug' => $files
        //     ]);
        // }
        // $documents = [
        //     'cv' => $files['cv'] ?? null,
        //     'diploma' => $files['diploma'] ?? null,
        //     'transcript' => $files['transcript'] ?? null,
        //     'coverletter' => $files['coverletter'] ?? null,
        //     'personalid' => $files['personalid'] ?? null
        // ];

        // foreach ($documents as $key => $filename) {
        //     if ($filename) {
        //         $filenameWithExt = $filename . '.pdf'; 

        //         $filePath = WRITEPATH . 'uploads/formapplicant/' . $filenameWithExt;

        //         if (file_exists($filePath)) {
        //             $documents[$key] = $filenameWithExt; // kirim ke JS yang lengkap
        //         } else {
        //             $documents[$key] = null;
        //         }
        //     } else {
        //         $documents[$key] = null;
        //     }
        // }

        if (!$dataDB) {
            return $this->response->setJSON([
                'response' => 'error',
                'message' => 'No data found.',
                // 'debug' => $files
            ]);
        }


        return $this->response->setJSON([
            'response' => 'success',
            'data' => $dataDB,
            // 'debug' => $files
        ]);
    }



    public function fn_viewcandidate()
    {
        $id = $this->request->getPost('id');
        $dataDB = $this->Md_adminpanel->getCandidateDocuments($id);
        // $candidate = $this->Md_adminpanel->getCandidateDetail($id);



        if (!$dataDB) {
            return $this->response->setJSON([
                'response' => 'error',
                'message' => 'No data found.',
                // 'debug' => $files
            ]);
        }


        return $this->response->setJSON([
            'response' => 'success',
            'data' => $dataDB,
            // 'debug' => $files
        ]);
    }


    public function previewCandidateFile($fileName = null)
    {
        if (!$fileName) {
            return $this->response->setStatusCode(400)->setBody('Missing filename');
        }

        $fileName = basename($fileName);

        // ✅ Tambahkan ini agar tidak double .pdf
        if (pathinfo($fileName, PATHINFO_EXTENSION) !== 'pdf') {
            $fileName .= '.pdf';
        }

        $filePath = WRITEPATH . 'uploads/formapplicant/' . $fileName;

        if (!file_exists($filePath)) {
            return $this->response->setStatusCode(404)->setBody('File not found');
        }

        $mime = mime_content_type($filePath);

        return $this->response
            ->setHeader('Content-Type', $mime)
            ->setHeader('Content-Disposition', 'inline; filename="' . $fileName . '"')
            ->setBody(file_get_contents($filePath));
    }


    public function fn_deletecandidate()
    {
        $id = $this->request->getPost('id');
        $result = $this->Md_adminpanel->fn_deletecandidate($id);
        if ($result) {
            return $this->response->setJSON([
                'response' => 'success',
                'message'  => 'Candidate deleted successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'response' => 'error',
                'message'  => 'Failed to delete candidate.'
            ]);
        }
    }


    public function fn_getchangepw()
    {         
      $this->$data['title'] = 'Change Password';
      return view('admin/vw_changepw', $this->$data);
    }


    public function fn_getprofile()
    {         
      $this->$data['title'] = 'Profile';
      return view('admin/vw_profile', $this->$data);
    }


    public function fn_addnewjobs()
    {
        $jobs = $this->request->getPost('jobs');
        $location = $this->request->getPost('location');
        $category = $this->request->getPost('category');
        $jobdescription = $this->request->getPost('jobdescription');
        $experience = $this->request->getPost('experience');
        $level = $this->request->getPost('level');
        $type = $this->request->getPost('type');
        $applicants = $this->request->getPost('applicants');
        $applydate = $this->request->getPost('applydate');
        $dateexpire = $this->request->getPost('dateexpire');


        $addjobs = $this->Md_adminpanel->fn_addnewjobs(
            $jobs,
            $location,
            $category,
            $jobdescription,
            $experience,
            $level,
            $type,
            $applicants,
            $applydate,
            $dateexpire,
            $this->generateShortUniqueID(30)
        );

        // Kirim respons JSON
        if ($addjobs) {
            return $this->response->setJSON([
                'response' => 'success',
                'message' => 'Data submitted successfully!',
                'data' => $addjobs,
            ]);
        } else {
            return $this->response->setJSON([
                'response' => 'error',
                'message' => 'Failed to submit data!',
            ], 400);
        }
    }

    public function fn_editJob()
    {
      $id = $this->request->getPost('id');
      $categories = $this->Md_adminpanel->fn_getcategory();
      $data = $this->Md_adminpanel->fn_editJobs($id);
      if ($data) {
          return $this->response->setJSON([
              'response' => 'success',
              'message' => 'Data retrieved successfully!',
              'data' => $data,
              'categories' => $categories,
          ]);
      } else {
          return $this->response->setJSON([
              'response' => 'error',
              'message' => 'Failed to retrieve data!',
          ], 400);
      }
    }

    public function fn_updateJob()
    {
        // Ambil data dari form
        $jobData = [
            'id' => $this->request->getPost('id'),
            'jobs' => $this->request->getPost('jobs'),
            'location' => $this->request->getPost('location'),
            'category' => $this->request->getPost('category'),
            'experience' => $this->request->getPost('experience'),
            'level' => $this->request->getPost('level'),
            'type' => $this->request->getPost('type'),
            'applicants' => $this->request->getPost('applicants'),
            'applydate' => $this->request->getPost('applydate'),
            'dateexpire' => $this->request->getPost('dateexpire'),
            'jobdescription' => $this->request->getPost('jobdescription')
        ];

        log_message('error', 'Job Data: ' . print_r($jobData, true));
    
        // Pastikan data tidak kosong sebelum diproses
        if (empty($jobData['id']) || empty($jobData['jobs']) || empty($jobData['location']) || empty($jobData['category']|| empty($jobData['jobdescription']) || empty($jobData['experience']) || empty($jobData['level']) || empty($jobData['type']) || empty($jobData['applicants']) || empty($jobData['applydate']) || empty($jobData['dateexpire']))) {
            return $this->response->setJSON([
                'response' => 'error',
                'message' => 'Some required fields are missing!'
            ], 400);
        }
    
        // Panggil model untuk mengupdate data
        $result = $this->Md_adminpanel->fn_updateJob(
            $jobData['id'],
            $jobData['jobs'],
            $jobData['location'],
            $jobData['category'],
            $jobData['jobdescription'],
            $jobData['experience'],
            $jobData['level'],
            $jobData['type'],
            $jobData['applicants'],
            $jobData['applydate'],
            $jobData['dateexpire']
        );
    
        // Response berdasarkan hasil update
        if ($result) {
            return $this->response->setJSON([
                'response' => 'success',
                'message' => 'Data updated successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'response' => 'error',
                'message' => 'Failed to update data!'
            ], 400);
        }
    }


    public function fn_deleteJob()
    {
        $id = $this->request->getPost('id');
        $result = $this->Md_adminpanel->fn_deleteJob($id);

        if ($result) {
            return $this->response->setJSON([
                'response' => 'success',
                'message' => 'Job deleted successfully!',
            ]);
        } else {
            return $this->response->setJSON([
                'response' => 'error',
                'message' => 'Failed to delete job!',
            ], 400);
        }
    }


    public function fn_deleteaccess()
    {
        $id = $this->request->getPost('id');
        $result = $this->Md_adminpanel->fn_deleteaccess($id);

        if ($result) {
            return $this->response->setJSON([
                'response' => 'success',
                'message' => 'Job deleted successfully!',
            ]);
        } else {
            return $this->response->setJSON([
                'response' => 'error',
                'message' => 'Failed to delete job!',
            ], 400);
        }
    }
}
    

  
  
    


 



  