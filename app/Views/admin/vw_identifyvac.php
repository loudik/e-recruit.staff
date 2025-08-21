<?= $this->extend('layoutAdmin/template') ?>
<?= $this->section('content') ?>

<!-- Scoped container agar CSS tidak mengganggu navbar/layout -->
<div id="doc-policy">

  <style>
    /* --- SCOPED CSS: hanya berlaku di dalam #doc-policy --- */
    #doc-policy .doc-wrap { padding:20px; }
    #doc-policy .doc-header { display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:10px; }
    #doc-policy .title-group { text-align:right; }
    #doc-policy .title-group h2 { margin:0; color:#6c63ff; font-size:16pt; }
    #doc-policy .title-group p { margin:0; font-size:10pt; color:#666; }
    #doc-policy .info { margin:20px 0 10px; }

    #doc-policy table { width:100%; border-collapse:collapse; table-layout:fixed; }
    #doc-policy th, #doc-policy td { border:1px solid #000; padding:8px; vertical-align:top; }
    #doc-policy th { text-align:center; background:#f0f0f0; font-weight:bold; }

    #doc-policy textarea.auto-grow{
      width: 100%;
      min-height: 60px;
      resize: none;
      overflow: hidden;
      line-height: 1.4;
      border: none;
      box-sizing: border-box;
      padding: 4px;
      font: inherit;
    }

    #doc-policy .date { margin-top: 16px; }
    #doc-policy .signature-section { margin-top: 24px; display:flex; gap:24px; flex-wrap: wrap; }
    #doc-policy .signature-box { flex:1 1 320px; line-height:1.6; border:1px dashed #ddd; padding:12px; border-radius:6px; }
    #doc-policy .sig-row { display:flex; gap:8px; margin-top:8px; }
    #doc-policy .qr-holder { display:flex; gap:12px; align-items:center; margin-top:10px; }
    #doc-policy .qr-box { width:128px; height:128px; display:grid; place-items:center; border:1px solid #ccc; }
    #doc-policy .small { font-size:10pt; color:#666; }

    /* Select2 height harmonized with Bootstrap form-control */
    #doc-policy .select2-container .select2-selection--single { height: 38px; }
    #doc-policy .select2-container--default .select2-selection--single .select2-selection__rendered { line-height:38px; }
    #doc-policy .select2-container--default .select2-selection--single .select2-selection__arrow { height:38px; }
  </style>

  <div class="row align-items-center">
    <div class="border-0 mb-4">
      <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
        <h3 class="fw-bold mb-0">Decision to Fill Vacancy</h3>
      </div>
    </div>
  </div>

  <div class="row align-item-center">
    <div class="col-12">
      <div class="card mb-3">
        <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
          <h6 class="mb-0 fw-bold">Recruitment Policy — ANP – HR</h6>
        </div>

        <div class="card-body">
          <!-- FORM -->
          <form id="vacancy-policy-form" data-parsley-validate onsubmit="event.preventDefault(); submitForm();">
            <div class="doc-wrap">
              <!-- header -->
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

              <!-- name + date -->
              <div class="row g-3 align-items-center">
                <div class="col-md-8">
                  <label for="position" class="form-label">Name of the Position</label>
                  <input type="text" class="form-control" id="position" placeholder="e.g. Database Support – GIP"
                          required data-parsley-required-message="Position is required">
                </div>
                <div class="col-md-4">
                  <label for="date" class="form-label">Date</label>
                  <input type="date" class="form-control" id="date"
                          required data-parsley-required-message="Date is required">
                </div>
              </div>

              <div class="mt-4"></div>

              <!-- Q&A -->
              <div class="table-responsive">
                <table class="table mb-0">
                  <thead>
                    <tr>
                      <th style="width:50%">Questions</th>
                      <th style="width:50%">Answers</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Does the job need to be <a href="#">filled</a>?</td>
                      <td>
                        <textarea id="answer1" class="auto-grow form-control" required
                          data-parsley-required-message="Please provide the answer."></textarea>
                      </td>
                    </tr>
                    <tr>
                      <td>What are the implications of not filling the vacancy?</td>
                      <td><textarea id="answer2" class="auto-grow form-control" required></textarea></td>
                    </tr>
                    <tr>
                      <td>What is the best method for filling the vacancy?</td>
                      <td><textarea id="answer3" class="auto-grow form-control" required></textarea></td>
                    </tr>
                    <tr>
                      <td>Do any aspects of the duties need to be changed to reflect current job requirements?</td>
                      <td><textarea id="answer4" class="auto-grow form-control" required></textarea></td>
                    </tr>
                    <tr>
                      <td>What are the skills and qualities required to perform the duties?</td>
                      <td><textarea id="answer5" class="auto-grow form-control" required></textarea></td>
                    </tr>
                    <tr>
                      <td>Do the current hours fit the duties?</td>
                      <td><textarea id="answer6" class="auto-grow form-control" required></textarea></td>
                    </tr>
                    <tr>
                      <td>Does the budget allow for the vacancy to be filled?</td>
                      <td><textarea id="answer7" class="auto-grow form-control" required></textarea></td>
                    </tr>
                    <tr>
                      <td>When is a candidate expected to join the ANP?</td>
                      <td><textarea id="answer8" class="auto-grow form-control" required></textarea></td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <!-- Signatures -->
              <div class="signature-section">
                <!-- Approved -->
                <div class="signature-box" id="box-approved">
                  <strong>Approved by (relevant directorate/department)</strong>
                  <div class="mt-2">
                    <select id="approved_select" class="form-select" data-placeholder="-- Select Approver --" required
                            data-parsley-errors-container="#approved_select_err" data-parsley-required-message="Approver is required">
                      <option></option>
                    </select>
                    <div id="approved_select_err"></div>
                  </div>
                  <div class="sig-row">
                    <input id="approved_name" class="form-control" placeholder="Name" required>
                    <input id="approved_position" class="form-control" placeholder="Position" required>
                  </div>
                  <div class="qr-holder">
                    <div class="qr-box" id="qr-approved"><span class="small">QR pending</span></div>
                    <div>
                      <div class="small">Scan For Verification</div>
                      <div id="link-approved" class="small"></div>
                    </div>
                  </div>
                </div>

                <!-- Received -->
                <div class="signature-box" id="box-received">
                  <strong>Received by</strong>
                  <div class="mt-2">
                    <select id="received_select" class="form-select" data-placeholder="-- Select Receiver --" required
                            data-parsley-errors-container="#received_select_err" data-parsley-required-message="Receiver is required">
                      <option></option>
                    </select>
                    <div id="received_select_err"></div>
                  </div>
                  <div class="sig-row">
                    <input id="received_name" class="form-control" placeholder="Name" required>
                    <input id="received_position" class="form-control" placeholder="Position" required>
                  </div>
                  <div class="qr-holder">
                    <div class="qr-box" id="qr-received"><span class="small">QR pending</span></div>
                    <div>
                      <div class="small">Scan For Verification</div>
                      <div id="link-received" class="small"></div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Actions -->
              <div class="text-center mt-4">
                <button id="btnSubmitVac" type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-outline-secondary ms-2">Cancel</button>
              </div>
            </div> <!-- /doc-wrap -->
          </form>
        </div>
      </div>
    </div>
  </div><!-- /row -->

</div><!-- /#doc-policy -->

<?= $this->endSection() ?>

<?php /* --------- SCRIPTS SECTION (agar tidak duplikat) ---------- */ ?>
<?= $this->section('scripts') ?>
  <!-- Select2 CSS (head biasanya di layout; boleh juga di sini jika belum) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
  <!-- Parsley CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/plugin/parsleyjs/css/parsley.css') ?>">

  <!-- Plugins -->
  <script src="<?= base_url('assets/plugin/parsleyjs/js/parsley.js') ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>

  <script>
    // ---------- Textarea auto-grow ----------
    function autoResize(el){
      if (!el) return;
      el.style.height = 'auto';
      el.style.height = (el.scrollHeight || 0) + 'px';
    }
    document.addEventListener('DOMContentLoaded', function(){
      document.querySelectorAll('#doc-policy textarea.auto-grow').forEach(autoResize);
    });
    document.addEventListener('input', function(e){
      if (e.target && e.target.matches('#doc-policy textarea.auto-grow')) autoResize(e.target);
    });

    // ---------- Parsley init ----------
    $(function() {
      $('#vacancy-policy-form').parsley();
    });

    // ---------- Select2 + Azure users ----------
    $(function () {
      initUserSelect($('#approved_select'));
      initUserSelect($('#received_select'));

      // Approved: fill fields
      $('#approved_select')
        .on('select2:select', e => {
          const s = e.params.data || {};
          $('#approved_name').val(s.displayname || s.text || '');
          $('#approved_position').val(s.jobTitle || '');
        })
        .on('select2:clear', () => {
          $('#approved_name, #approved_position').val('');
        });

      // Received: fill fields
      $('#received_select')
        .on('select2:select', e => {
          const s = e.params.data || {};
          $('#received_name').val(s.displayname || s.text || '');
          $('#received_position').val(s.jobTitle || '');
        })
        .on('select2:clear', () => {
          $('#received_name, #received_position').val('');
        });
    });

    function initUserSelect($el) {
      if ($el.hasClass('select2-hidden-accessible')) $el.select2('destroy').empty();
      $el.select2({
        placeholder: $el.data('placeholder') || 'Select employee',
        width: '100%',
        allowClear: true,
        minimumInputLength: 0,
        ajax: {
          url: "<?= base_url('admin/users-json') ?>",
          dataType: 'json',
          delay: 300,
          data: params => ({ search: (params && params.term) ? params.term : '' }),
          processResults: data => ({
            results: (data.users || []).map(u => ({
              id: u.id,
              text: u.displayName || u.userPrincipalName,
              displayname: u.displayName || '',
              jobTitle: u.jobTitle || '',
              email: (u.mail || u.userPrincipalName || '').trim(),
              upn: u.userPrincipalName || ''
            }))
          }),
          cache: true
        },
        templateResult: item => {
          if (!item.id) return item.text;
          const jt = item.jobTitle ? ' — <small>' + item.jobTitle + '</small>' : '';
          return $('<span>' + (item.text || '') + jt + '</span>');
        },
        templateSelection: item => {
          const jt = item.jobTitle ? ' — ' + item.jobTitle : '';
          return (item.text || '') + jt;
        },
        escapeMarkup: m => m,
        language: { inputTooShort: () => '' }
      });

      $el.on('select2:open', () => {
        const inp = document.querySelector('.select2-container--open .select2-search__field');
        if (inp) inp.setAttribute('placeholder', 'Search...');
      });
    }

    // ---------- Submit (AJAX) ----------
    function submitForm () {
      // stop if parsley invalid
      const form = $('#vacancy-policy-form');
      if (!form.parsley().isValid()) { form.parsley().validate(); return; }

      const apv = ($('#approved_select').select2('data') || [])[0] || {};
      const rec = ($('#received_select').select2('data') || [])[0] || {};

      const payload = {
        position:  ($('#position').val() || '').trim(),
        date:      ($('#date').val() || '').trim(),
        answers: {
          answer1: ($('#answer1').val() || '').trim(),
          answer2: ($('#answer2').val() || '').trim(),
          answer3: ($('#answer3').val() || '').trim(),
          answer4: ($('#answer4').val() || '').trim(),
          answer5: ($('#answer5').val() || '').trim(),
          answer6: ($('#answer6').val() || '').trim(),
          answer7: ($('#answer7').val() || '').trim(),
          answer8: ($('#answer8').val() || '').trim(),
        },
        approver: {
          ms_id:    apv.id || '',
          name:     ($('#approved_name').val() || apv.text || '').trim(),
          jobTitle: ($('#approved_position').val() || apv.jobTitle || '').trim(),
          email:    (apv.email || apv.upn || '').trim()
        },
        receiver: {
          ms_id:    rec.id || '',
          name:     ($('#received_name').val() || rec.text || '').trim(),
          jobTitle: ($('#received_position').val() || rec.jobTitle || '').trim(),
          email:    (rec.email || rec.upn || '').trim()
        }
      };

      if (!payload.approver.ms_id) return alert('Please choose an Approver from directory.');
      if (!payload.receiver.ms_id) return alert('Please choose a Receiver from directory.');

      const $btn = $('#btnSubmitVac').prop('disabled', true).text('Submitting...');

      // CSRF header (CI4)
      const csrfHeaderName = '<?= csrf_token() ?>';
      const csrfHash = '<?= csrf_hash() ?>';

      $.ajax({
        url: "<?= base_url('admin/vacancy/submit') ?>",
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(payload),
        headers: Object.assign({'X-Requested-With':'XMLHttpRequest'}, { [csrfHeaderName]: csrfHash }),
        success: function (res) {
          try { console.log('Response:', res); } catch(e){}
          if (res && res.ok) {
            if (res.emailSent) {
              alert('Submitted! Approval email sent to approver.');
            } else {
              let msg = 'Submitted, but email was not sent.';
              if (res.mailError) msg += `\n[debug] ${res.mailError.exception || ''}`;
              if (res.approveUrl) msg += `\nSend this link manually:\n${res.approveUrl}`;
              alert(msg);
            }
          } else {
            alert('Failed: ' + (res?.message || 'Unknown error'));
          }
        },
        error: function (xhr) {
          alert('Request failed: ' + (xhr?.status || '') + ' ' + (xhr?.statusText || ''));
        },
        complete: function(){
          $btn.prop('disabled', false).text('Submit');
        }
      });
    }
  </script>
<?= $this->endSection() ?>
