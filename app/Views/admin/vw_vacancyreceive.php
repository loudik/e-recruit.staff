<?= $this->extend('layoutAdmin/template') ?>
<?= $this->section('content') ?>

<div id="doc-policy">

  <style>
    /* ===== Scoped CSS hanya untuk halaman ini ===== */
    #doc-policy .doc-header{display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:10px}
    #doc-policy .title-group{text-align:right}
    #doc-policy .title-group h2{margin:0;color:#6c63ff;font-size:16pt}
    #doc-policy .title-group p{margin:0;font-size:10pt;color:#666}
    #doc-policy .info{margin:20px 0 10px}
    #doc-policy table{width:100%;border-collapse:collapse;table-layout:fixed}
    #doc-policy th,#doc-policy td{border:1px solid #000;padding:8px;vertical-align:top}
    #doc-policy th{text-align:center;background:#f0f0f0;font-weight:bold}
    #doc-policy textarea.auto-grow{width:100%;min-height:60px;resize:none;overflow:hidden;line-height:1.4;border:none;box-sizing:border-box;padding:4px;font:inherit}
    #doc-policy .date{margin-top:16px}
    #doc-policy .signature-section{margin-top:24px;display:flex;gap:24px;flex-wrap:wrap}
    #doc-policy .signature-box{flex:1 1 320px;line-height:1.6;border:1px dashed #ddd;padding:12px;border-radius:6px}
    #doc-policy .sig-row{display:flex;gap:8px;margin-top:8px}
    #doc-policy .sig-row input{width:100%;padding:8px;font-size:12pt}
    #doc-policy .qr-holder{display:flex;gap:12px;align-items:center;margin-top:10px;justify-content:center;text-align:center;flex-direction:column}
    #doc-policy .qr-box{width:128px;height:128px;display:grid;place-items:center;border:1px solid #ccc}
    #doc-policy .small{font-size:10pt;color:#666}
    #doc-policy .form-actions{text-align:center;margin-top:24px}
    #doc-policy .form-actions button{padding:10px 20px;margin:0 10px;font-size:14px;font-weight:bold;border:none;border-radius:4px;cursor:pointer;background:#6c63ff;color:#fff;transition:background-color .3s ease}
    #doc-policy .form-actions button:hover{background:#574fd6}
    #doc-policy .form-actions button[type="reset"]{background:#ccc;color:#000}
    #doc-policy .form-actions button[type="reset"]:hover{background:#999}
  </style>

  <div class="row align-items-center">
    <div class="border-0 mb-4">
      <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
        <h3 class="fw-bold mb-0"><?= esc($title ?? 'Recruitment Policy') ?></h3>
      </div>
    </div>
  </div>

  <div class="card mb-3">
    <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
      <h6 class="mb-0 fw-bold">Recruitment Policy — ANP – HR</h6>
    </div>

    <div class="card-body">
      <div class="doc-header">
        <div></div>
        <div class="title-group">
          <h2>RECRUITMENT POLICY</h2>
          <p>DECISION TO FILL VACANCY</p>
          <p><small>ANP – HR</small></p>
        </div>
      </div>
      <hr>

      <div class="info">
        Directors should start planning immediately if a vacancy occurs or as soon as it is known that a vacancy will be occurring by considering the following. The directors or supervisors need to fill in this form and submit it to HR. This form needs to be submitted to HR for the Recruitment Plan before the advertisement of the vacancy. This form is based on ANPM/05/03/02 Rev 1 Recruitment Policy clause “3.2 Decision to Fill a Vacancy.”
      </div>

      <p>
        <strong>Name of the Position:</strong>
        <input id="position" value="<?= esc($data['position'] ?? '') ?>"
               style="border:0;border-bottom:1px solid #000;outline:0;width:60%" readonly />
      </p>
      <div class="date">
        <strong>Date:</strong>
        <input id="date" type="date"
               value="<?= esc(($data['approved_at'] ?? $data['date'] ?? '') ? substr(($data['approved_at'] ?? $data['date']),0,10) : '') ?>" readonly />
      </div>

      <br><br>

      <div class="table-responsive">
        <table>
          <thead>
            <tr><th style="width:50%">Questions</th><th style="width:50%">Answers</th></tr>
          </thead>
          <tbody>
            <tr>
              <td>Does the job need to be <a href="#">filled</a>?</td>
              <td><textarea id="answer1" class="auto-grow" readonly><?= esc($answers['answer1'] ?? '') ?></textarea></td>
            </tr>
            <tr>
              <td>What are the implications of not filling the vacancy?</td>
              <td><textarea id="answer2" class="auto-grow" readonly><?= esc($answers['answer2'] ?? '') ?></textarea></td>
            </tr>
            <tr>
              <td>What is the best method for filling the vacancy?</td>
              <td><textarea id="answer3" class="auto-grow" readonly><?= esc($answers['answer3'] ?? '') ?></textarea></td>
            </tr>
            <tr>
              <td>Do any aspects of the duties need to be changed to reflect current job requirements?</td>
              <td><textarea id="answer4" class="auto-grow" readonly><?= esc($answers['answer4'] ?? '') ?></textarea></td>
            </tr>
            <tr>
              <td>What are the skills and qualities required to perform the duties?</td>
              <td><textarea id="answer5" class="auto-grow" readonly><?= esc($answers['answer5'] ?? '') ?></textarea></td>
            </tr>
            <tr>
              <td>Do the current hours fit the duties?</td>
              <td><textarea id="answer6" class="auto-grow" readonly><?= esc($answers['answer6'] ?? '') ?></textarea></td>
            </tr>
            <tr>
              <td>Does the budget allow for the vacancy to be filled?</td>
              <td><textarea id="answer7" class="auto-grow" readonly><?= esc($answers['answer7'] ?? '') ?></textarea></td>
            </tr>
            <tr>
              <td>When is a candidate expected to join the ANP?</td>
              <td><textarea id="answer8" class="auto-grow" readonly><?= esc($answers['answer8'] ?? '') ?></textarea></td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="signature-section">
        <!-- APPROVED -->
        <div class="signature-box" id="box-approved">
          <strong>Approved by (relevant directorate/department)</strong>
          <div class="sig-row">
            <input id="approved_name" value="<?= esc($approver['name'] ?? '') ?>" placeholder="Name" readonly />
            <input id="approved_position" value="<?= esc($approver['jobTitle'] ?? '') ?>" placeholder="Position" readonly />
          </div>

          <div class="qr-holder">
            <div id="qr-approved" class="qr-box"><span class="small">QR</span></div>
            <div>
              <div id="qr-approve-text" class="small" style="display:none;">Scan for Verification</div>
            </div>
          </div>
        </div>

        <!-- RECEIVED -->
        <div class="signature-box" id="box-received">
          <strong>Received by</strong>
          <div class="sig-row">
            <input id="received_name"
               value="<?= esc($receiver['name'] ?? '') ?>"
               placeholder="Name" readonly />
            <input id="received_position"
               value="<?= esc($receiver['jobTitle'] ?? '') ?>"
               placeholder="Position" readonly />
          </div>
          <div class="qr-holder" style="margin-top:12px; text-align:center;">
            <div id="qr-received" class="qr-box"><span class="small">QR</span></div>
            <div class="small" id="qr-received-hint">Scan for Verification</div>

            <!-- Link fallback (hidden by default) -->
            <div id="qr-received-link" style="display:none; word-break:break-all;">
              <?php if (!empty($qrTextReceived ?? '')): ?>
                <a href="<?= esc($qrTextReceived) ?>" target="_blank"><?= esc($qrTextReceived) ?></a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>

      <div class="form-actions">
        <button type="button" id="btnReceive" onclick="Receive()">Received</button>
        <button type="reset">Cancel</button>
      </div>

    </div><!-- /.card-body -->
  </div><!-- /.card -->

</div><!-- /#doc-policy -->

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <!-- QRCode -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

  <script>
    // Auto-grow readonly textareas on load
    (function(){
      document.querySelectorAll('#doc-policy textarea.auto-grow').forEach(function(t){
        t.style.height='auto';
        t.style.height=(t.scrollHeight||0)+'px';
      });
    })();

    // Initial QR render from server (approved/received)
    (function () {
      var qrApprovedText = "<?= esc($data['qr_text_approved'] ?? '', 'js') ?>";
      if (qrApprovedText) {
        var el = document.getElementById('qr-approved');
        if (el) {
          el.innerHTML = '';
          new QRCode(el, { text: qrApprovedText, width:128, height:128, correctLevel: QRCode.CorrectLevel.M });
          var hint = document.getElementById('qr-approve-text');
          if (hint) hint.style.display = 'block';
        }
      }

      var qrReceivedText = "<?= esc($data['qr_text_received'] ?? '', 'js') ?>";
      if (qrReceivedText) {
        renderQR('qr-received', qrReceivedText);
      } else {
        // fallback link jika ada
        var linkDiv = document.getElementById('qr-received-link');
        if (linkDiv && linkDiv.querySelector('a')) linkDiv.style.display = 'block';
      }
    })();

    function renderQR(targetId, text) {
      var el = document.getElementById(targetId);
      if (!el || !text) return;

      if (typeof QRCode === 'undefined') {
        console.warn('QRCode lib not loaded; showing link fallback');
        var linkDiv = document.getElementById('qr-received-link');
        if (linkDiv) linkDiv.style.display = 'block';
        return;
      }
      el.innerHTML = '';
      new QRCode(el, { text: text, width: 128, height: 128, correctLevel: QRCode.CorrectLevel.M });

      var hint = document.getElementById('qr-received-hint');
      if (hint) hint.style.display = 'block';
      var linkDiv = document.getElementById('qr-received-link');
      if (linkDiv) linkDiv.style.display = 'none';
    }

    // Action: mark as Received
    async function Receive() {
      const doc    = "<?= esc($doc ?? '', 'js') ?>";
      const rtoken = "<?= esc($rtoken ?? '', 'js') ?>";
      const btn    = document.getElementById("btnReceive");

      if (!doc || !rtoken) { alert("Invalid payload"); return; }

      if (btn) { btn.disabled = true; btn.textContent = "Processing..."; }

      // CSRF headers (CI4)
      const csrfHeader = "<?= csrf_token() ?>";
      const csrfHash   = "<?= csrf_hash() ?>";

      try {
        const resp = await fetch("<?= url_to('vacancy-do-receive') ?>", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-Requested-With": "XMLHttpRequest",
            [csrfHeader]: csrfHash
          },
          body: new URLSearchParams({ doc, rtoken })
        });

        const res = await resp.json();

        if (!res || res.ok !== true || !res.qr) {
          const msg = (res && res.msg) ? res.msg : (resp.status + " " + resp.statusText);
          alert("Receive failed: " + msg);
          if (btn) { btn.disabled = false; btn.textContent = "Received"; }
          return;
        }

        // Render QR Received baru
        renderQR('qr-received', res.qr);

        // Sembunyikan tombol aksi
        const actions = document.querySelector("#doc-policy .form-actions");
        if (actions) actions.style.display = "none";

        alert("Marked as Received!");
      } catch (err) {
        alert("Error: " + err);
        if (btn) { btn.disabled = false; btn.textContent = "Received"; }
      }
    }
  </script>
<?= $this->endSection() ?>
