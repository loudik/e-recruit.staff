<?= $this->extend('layoutAdmin/template') ?>
<?= $this->section('content') ?>

<!-- <div id="vacancy-signature" class="theme-blue"> -->

  <style>
    /* scope biar aman */
    #vacancy-signature .kpi .alert{margin:0}
    #vacancy-signature .qr-box{width:128px;height:128px;display:grid;place-items:center;border:1px solid #e5e7eb;border-radius:8px}
    #vacancy-signature .mono{font-family:ui-monospace,Consolas,monospace;word-break:break-all}
    #vacancy-signature table.answers th,
    #vacancy-signature table.answers td{vertical-align:top}
    #vacancy-signature .badge-soft{border:1px solid transparent;padding:.35rem .6rem;border-radius:50rem}
    #vacancy-signature .badge-soft.success{background:#e7f6ec;color:#2e7d32;border-color:#c8e6c9}
    #vacancy-signature .badge-soft.danger{background:#fdecee;color:#c62828;border-color:#f5c6cb}

  .badge-soft{border:1px solid transparent;padding:.35rem .6rem;border-radius:50rem;font-size:.75rem}
  .badge-soft.success{background:#e7f6ec;color:#2e7d32;border-color:#c8e6c9}
  .badge-soft.danger{background:#fdecee;color:#c62828;border-color:#f5c6cb}


  </style>

  <!-- Header -->
  <div class="row align-items-center">
    <div class="border-0 mb-4">
      <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
        <h3 class="fw-bold mb-0">Decision to Fill Vacancy — Signature Details</h3>
        <span class="badge-soft <?= !empty($ok)?'success':'danger' ?>">
          <?= !empty($ok) ? 'Signature Verified' : 'Invalid / Expired Signature' ?>
        </span>
      </div>
    </div>
  </div>

  <!-- KPI cards -->
  <div class="row g-3 mb-3 row-cols-1 row-cols-sm-2 row-cols-lg-4 kpi">
    <div class="col">
      <div class="alert-info alert">
        <div class="d-flex align-items-center">
          <div class="avatar rounded no-thumbnail bg-info text-light"><i class="fa fa-briefcase"></i></div>
          <div class="flex-fill ms-3 text-truncate">
            <div class="h6 mb-0">Position</div>
            <span class="small"><?= esc($data['position'] ?? ($data['doc'] ?? '—')) ?></span>
          </div>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="alert-success alert">
        <div class="d-flex align-items-center">
          <div class="avatar rounded no-thumbnail bg-success text-light"><i class="fa fa-check-circle"></i></div>
          <div class="flex-fill ms-3 text-truncate">
            <div class="h6 mb-0">Approved At</div>
            <span class="small"><?= esc($approved['time'] ?? '-') ?></span>
          </div>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="alert-primary alert">
        <div class="d-flex align-items-center">
          <div class="avatar rounded no-thumbnail bg-primary text-light"><i class="fa fa-inbox"></i></div>
          <div class="flex-fill ms-3 text-truncate">
            <div class="h6 mb-0">Received At</div>
            <span class="small"><?= esc($received['time'] ?? '-') ?></span>
          </div>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="alert-warning alert">
        <div class="d-flex align-items-center">
          <div class="avatar rounded no-thumbnail bg-warning text-light"><i class="fa fa-id-badge"></i></div>
          <div class="flex-fill ms-3 text-truncate">
            <div class="h6 mb-0">Doc UID</div>
            <span class="small mono"><?= esc($data['uid'] ?? '-') ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 3 columns: Approved, Received, Summary -->
  <div class="row g-3 mb-3 row-cols-1 row-cols-lg-3">
  

  <!-- Approved -->
    <div class="col">
      <div class="card">
        <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
          <h6 class="mb-0 fw-bold">Approved by</h6>
          <span class="badge-soft <?= ($approved_status ?? 'pending') === 'verified' ? 'success' : 'danger' ?>">
            <?= ($approved_status ?? 'pending') === 'verified' ? 'Verified' : 'Pending' ?>
          </span>
        </div>
        <div class="card-body">
          <div class="row g-2">
            <div class="col-12"><label class="form-label col-5">Name:</label><span><strong> <?= esc($approved['name'] ?? '-') ?></strong></span></div>
            <div class="col-12"><label class="form-label col-5">Position:</label><span><strong> <?= esc($approved['jobTitle'] ?? '-') ?></strong></span></div>
            <div class="col-12"><label class="form-label col-5">Email:</label><span class="mono"><strong> <?= esc($approved['email'] ?? '-') ?></strong></span></div>
            <div class="col-12"><label class="form-label col-5">Time:</label><span><strong> <?= esc($approved['time'] ?? '-') ?></strong></span></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Received -->
    <div class="col">
      <div class="card">
        <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
          <h6 class="mb-0 fw-bold">Received by</h6>
          <span class="badge-soft <?= ($received_status ?? 'pending') === 'verified' ? 'success' : 'danger' ?>">
            <?= ($received_status ?? 'pending') === 'verified' ? 'Verified' : 'Pending' ?>
          </span>
        </div>
        <div class="card-body">
          <div class="row g-2">
            <div class="col-12"><label class="form-label col-5">Name:</label><span><strong> <?= esc($received['name'] ?? '-') ?></strong></span></div>
            <div class="col-12"><label class="form-label col-5">Position:</label><span><strong> <?= esc($received['jobTitle'] ?? '-') ?></strong></span></div>
            <div class="col-12"><label class="form-label col-5">Email:</label><span class="mono"><strong> <?= esc($received['email'] ?? '-') ?></strong></span></div>
            <div class="col-12"><label class="form-label col-5">Time:</label><span><strong> <?= esc($received['time'] ?? '-') ?></strong></span></div>
          </div>
        </div>
      </div>
    </div>


    <!-- Summary -->
    <div class="col">
      <div class="card">
        <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
          <h6 class="mb-0 fw-bold">Summary</h6>
          <span class="badge-soft <?= !empty($ok)?'success':'danger' ?>">
            <?= !empty($ok) ? 'Valid' : 'Invalid' ?>
          </span>
        </div>
        <div class="card-body">
          <div class="row g-2">
            <div class="col-12"><label class="form-label col-5">Document:</label><span class="mono"><strong> <?= esc($data['doc'] ?? '-') ?></strong></span></div>
            <div class="col-12"><label class="form-label col-5">Role:</label><span><strong> <?= esc($data['role'] ?? '-') ?></strong></span></div>
            <div class="col-12"><label class="form-label col-5">Position:</label><span><strong> <?= esc($data['position'] ?? '-') ?></strong></span></div>
          </div>
          <?php if (empty($ok)): ?>
            <div class="alert alert-danger mt-3 mb-0">
              ❌ <?= esc($err ?? 'Invalid or Expired Signature') ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Q&A -->
  <div class="row g-3">
    <div class="col-12">
      <div class="card">
        <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
          <h6 class="mb-0 fw-bold">Decision Questions & Answers</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table answers">
              <thead>
                <tr>
                  <th style="width:45%">Question</th>
                  <th>Answer</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $qa = [
                    'Does the job need to be filled?' => $answers['answer1'] ?? '',
                    'What are the implications of not filling the vacancy?' => $answers['answer2'] ?? '',
                    'What is the best method for filling the vacancy?' => $answers['answer3'] ?? '',
                    'Do duties need to be changed to reflect current requirements?' => $answers['answer4'] ?? '',
                    'What are the skills and qualities required?' => $answers['answer5'] ?? '',
                    'Do the current hours fit the duties?' => $answers['answer6'] ?? '',
                    'Does the budget allow for the vacancy to be filled?' => $answers['answer7'] ?? '',
                    'When is a candidate expected to join the ANP?' => $answers['answer8'] ?? '',
                  ];
                  foreach ($qa as $q => $a):
                ?>
                <tr>
                  <td><?= esc($q) ?></td>
                  <td><?= nl2br(esc($a)) ?></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

</div><!-- /#vacancy-signature -->

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
  <!-- QRCode generator -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>


  <script>
 

    (function(){
      var approvedStatus = "<?= esc($approved_status ?? 'pending') ?>";
        var receivedStatus = "<?= esc($received_status ?? 'pending') ?>";

        var qrApproved = (approvedStatus === 'verified')
            ? "<?= esc($data['qr_text_approved'] ?? ($approved['qr'] ?? ''), 'js') ?>"
            : "";
        var qrReceived = (receivedStatus === 'verified')
            ? "<?= esc($data['qr_text_received'] ?? ($received['qr'] ?? ''), 'js') ?>"
            : "";

        function drawQR(id, text){
          var el = document.getElementById(id);
          if (!el || !text || typeof QRCode === 'undefined') return;
          el.innerHTML = '';
          new QRCode(el, { text: text, width:128, height:128, correctLevel: QRCode.CorrectLevel.M });
        }

        drawQR('qr-approved', qrApproved);
        drawQR('qr-received', qrReceived);
      })();
  </script>
<?= $this->endSection() ?>
