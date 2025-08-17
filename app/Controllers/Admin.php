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
        $this->signKey = getenv('APP_SIGNATURE_KEY') ?: getenv('app.signatureKey') ?: 'CHANGE_ME_SECRET';
        
    }

    public function fn_getvacancy($microsoftId = null)
    {
        // Ambil Microsoft ID dari session (abaikan parameter)
        $microsoftId = session()->get('microsoft_id');

        // Cek akses user
        $access = $this->Md_administrator->getAccessByMicrosoftId($microsoftId);
        if (!$access) {
            echo "Data tidak ditemukan untuk Microsoft ID: $microsoftId"; 
            exit;
        }

        // Siapkan data menu & selected menus
        $selectedMenus = array_map('intval', explode(',', $access['menu_ids'] ?? ''));

        $this->data['menus']         = $this->Md_administrator->getAllMenus();
        $this->data['selectedMenus'] = $selectedMenus;
        $this->data['access']        = $access;

        // Biarkan kosong; Select2 akan fetch via /admin/users-json
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

    // Normalisasi tanggal
    $date = '';
    if ($dateRaw !== '') {
        try { $date = (new \DateTime($dateRaw))->format('Y-m-d'); } catch (\Throwable $e) {}
    }

    if ($position === '' || $date === '' || empty($appr['ms_id'])) {
        return $this->response->setStatusCode(422)->setJSON([
            'ok'=>false,
            'message'=>'Position, Date, dan Approver wajib diisi'
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
            'submitter_upn' => (string) (session('microsoft_upn') ?: session('microsoft_id')),
        ]);
    } catch (\InvalidArgumentException $e) {
        return $this->response->setStatusCode(422)->setJSON(['ok'=>false,'message'=>$e->getMessage()]);
    } catch (\Throwable $e) {
        return $this->response->setStatusCode(500)->setJSON(['ok'=>false,'message'=>$e->getMessage()]);
    }

    $id    = (int) $result['id'];
    $token = (string) $result['token'];

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
            $resp['mailError'] = $this->lastMailError; // <— lihat kenapa gagal
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
                        <p>Mohon approval untuk posisi:</p>
                        <p><strong>'.$safeTitle.'</strong></p>
                        <p><a href="'.$safeUrl.'" style="background:#0a77ff;color:#fff;padding:10px 16px;text-decoration:none;border-radius:6px">Approve Now</a></p>
                        <p>Atau buka tautan: '.$safeUrl.'</p>
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
            $res    = $client->post('https://graph.microsoft.com/v1.0/me/sendMail', [/*...*/]);
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

        private function sign(string $data, string $key): string
        {
            // HMAC-SHA256 → base64url no padding
            return rtrim(strtr(base64_encode(hash_hmac('sha256', $data, $key, true)), '+/', '-_'), '=');
        }

        public function approve()
            {
                $id    = (int) $this->request->getGet('doc');
                $token = (string) $this->request->getGet('token');

                if (!$id || !$token) {
                    return $this->response->setStatusCode(400)->setBody('Bad request');
                }

                $row = $this->Md_vacancy->find($id);
                if (!$row || (int)$row['status'] !== 0) {
                    return $this->response->setStatusCode(404)->setBody('Not found or already handled');
                }
                if (!hash_equals((string)$row['approval_token'], $token)) {
                    return $this->response->setStatusCode(403)->setBody('Invalid token');
                }
                if (!empty($row['approval_token_exp']) && Time::now()->isAfter(Time::parse($row['approval_token_exp']))) {
                    return $this->response->setStatusCode(410)->setBody('Token expired');
                }

                // Buat QR verify URL bertanda tangan
                $role = 'approved';
                $uid  = (string) ($row['apv_ms_id'] ?? '');
                $ts   = time();
                $sig  = $this->sign("$id|$role|$uid|$ts", $this->signKey);
                $qrUrl = site_url('verify/signature?doc='.$id.'&role='.$role.'&uid='.$uid.'&ts='.$ts.'&sig='.$sig);

                // Update status: APPROVED
                $this->Md_vacancy->update($id, [
                    'status'           => 1,
                    'approved_at'      => Time::now()->toDateTimeString(),
                    'qr_text_approved' => $qrUrl,
                    'udt'              => Time::now()->toDateTimeString(),
                    'uby'              => (string) (session('microsoft_upn') ?: session('microsoft_id')),
                ]);

                return view('vacancyapproval/approved', [
                    'title'  => 'Vacancy Approved',
                    'doc'    => $id,
                    'qrText' => $qrUrl,
                ]);
            }

        


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
        //  $this->data['sidebarMenus'] = $this->loadSidebarMenus();      
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

    public function fn_editJob(){
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
    

  
  
    


 



  