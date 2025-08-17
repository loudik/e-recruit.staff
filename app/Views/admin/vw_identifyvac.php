<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Decision to Fill Vacancy</title>
  <link rel="icon" href="<?= $logoPath ?>" type="image/png">
  <style>
    @page { size: A4 landscape; margin: 20mm; }
    html, body { width:100%; min-height:794px; margin:0; padding:20px; font-family:Arial, sans-serif; font-size:12pt; box-sizing:border-box; }
    .header { display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:10px; }
    .title-group { text-align:right; }
    .title-group h2 { margin:0; color:#6c63ff; font-size:16pt; }
    .title-group p { margin:0; font-size:10pt; color:#666; }
    .info { margin:20px 0 10px; }
    table { width:100%; border-collapse:collapse; table-layout:fixed; }
    th, td { border:1px solid #000; padding:8px; vertical-align:top; }
    th { text-align:center; background:#f0f0f0; font-weight:bold; }
    td textarea { width:100%; border:none; resize:none; overflow:hidden; font-family:inherit; font-size:inherit; line-height:1.4; box-sizing:border-box; padding:4px; min-height:60px; }
    td textarea:focus { outline:none; }
    .date { margin-top: 16px; }
    .signature-section { margin-top: 24px; display:flex; gap:24px; }
    .signature-box { flex:1 1 0; line-height:1.6; border:1px dashed #ddd; padding:12px; border-radius:6px; }
    .sig-row { display:flex; gap:8px; margin-top:8px; }
    .sig-row input, .sig-row select, .form-select { width:100%; padding:8px; font-size:12pt; }
    .qr-holder { display:flex; gap:12px; align-items:center; margin-top:10px; }
    .qr-box { width:128px; height:128px; display:grid; place-items:center; border:1px solid #ccc; }
    .small { font-size:10pt; color:#666; }
    .form-actions { margin-top: 24px; text-align:center; }
    .form-actions button { padding:10px 20px; margin:0 10px; font-size:14px; font-weight:bold; border:none; border-radius:4px; cursor:pointer; background:#6c63ff; color:#fff; transition:background-color .3s ease; }
    .form-actions button:hover { background:#574fd6; }
    .form-actions button[type="reset"] { background:#ccc; color:#000; }
    .form-actions button[type="reset"]:hover { background:#999; }
    textarea.auto-grow{
      width: 100%;
      min-height: 60px;
      resize: none;        /* user tidak tarik-tarik manual */
      overflow: hidden;    /* sembunyikan scrollbar */
      line-height: 1.4;
      border: none;        /* sesuai style form kamu sebelumnya */
      box-sizing: border-box;
      padding: 4px;
      font: inherit;
    }

  </style>
</head>
<body>

  <div class="header">
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

  <!-- Name of Position + Date -->
  <p>
    <strong>Name of the Position:</strong>
    <input id="position" style="border:0;border-bottom:1px solid #000;outline:0;width:60%" placeholder="e.g. Database Support – GIP" />
  </p>
  <div class="date">
    <strong>Date:</strong>
    <input id="date" type="date" />
  </div>

  <table>
    <thead>
      <tr><th style="width:50%">Questions</th><th style="width:50%">Answers</th></tr>
    </thead>
    <tbody>
      <tr><td>Does the job need to be <a href="#">filled</a>?</td><td><textarea id="answer1" class="auto-grow""></textarea></td></tr>
      <tr><td>What are the implications of not filling the vacancy?</td><td><textarea id="answer2" class="auto-grow""></textarea></td></tr>
      <tr><td>What is the best method for filling the vacancy?</td><td><textarea id="answer3" class="auto-grow""></textarea></td></tr>
      <tr><td>Do any aspects of the duties need to be changed to reflect current job requirements?</td><td><textarea id="answer4" class="auto-grow""></textarea></td></tr>
      <tr><td>What are the skills and qualities required to perform the duties?</td><td><textarea id="answer5" class="auto-grow""></textarea></td></tr>
      <tr><td>Do the current hours fit the duties?</td><td><textarea id="answer6" class="auto-grow""></textarea></td></tr>
      <tr><td>Does the budget allow for the vacancy to be filled?</td><td><textarea id="answer7" class="auto-grow""></textarea></td></tr>
      <tr><td>When is a candidate expected to join the ANP?</td><td><textarea id="answer8" class="auto-grow""></textarea></td></tr>
    </tbody>
  </table>

  <div class="signature-section">
    <!-- APPROVED -->
    <div class="signature-box" id="box-approved">
      <strong>Approved by (relevant directorate/department)</strong>
     <select id="approved_select" class="form-select mb-2" data-placeholder="-- Select from Approval --">
        <option></option>
      </select>
      <div class="sig-row">
        <input id="approved_name" placeholder="Name" />
        <input id="approved_position" placeholder="Position" />
</div>
      <div class="qr-holder">
        <div class="qr-box" id="qr-approved"><span class="small">QR pending</span></div>
        <div>
          <div class="small">Scan untuk verifikasi</div>
          <div id="link-approved" class="small"></div>
        </div>
      </div>
    </div>

    <!-- RECEIVED -->
    <div class="signature-box" id="box-received">
      <strong>Received by</strong>
      <select id="received_select" class="form-select mb-2" data-placeholder="-- Select from Received --">
  <option></option>
</select>
<div class="sig-row">
  <input id="received_name" placeholder="Name" />
  <input id="received_position" placeholder="Position" />
</div>
      <div class="qr-holder">
        <div class="qr-box" id="qr-received"><span class="small">QR pending</span></div>
        <div>
          <div class="small">Scan untuk verifikasi</div>
          <div id="link-received" class="small"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="form-actions">
    <button type="button" onclick="submitForm()">Submit</button>
    <button type="reset">Cancel</button>
  </div>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>

<script>
  function autoResize(el){
    if (!el) return;
    el.style.height = 'auto';
    el.style.height = (el.scrollHeight || 0) + 'px';
  }
  // optional: tetap expose ke global kalau masih ada inline di tempat lain
  window.autoResize = autoResize;

  // Auto apply saat halaman siap
  document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('textarea.auto-grow').forEach(autoResize);
  });

  // Reaktif ketika user mengetik (delegated event)
  document.addEventListener('input', function(e){
    if (e.target && e.target.matches('textarea.auto-grow')) {
      autoResize(e.target);
    }
  });
  
$(function () {
  initUserSelect($('#approved_select'));
  initUserSelect($('#received_select'));

  // Approved: isi field
  $('#approved_select')
    .on('select2:select', e => {
      const s = e.params.data || {};
      $('#approved_name').val(s.displayname || s.text || '');
      $('#approved_position').val(s.jobTitle || '');
    })
    .on('select2:clear', () => {
      $('#approved_name, #approved_position').val('');
    });

  // Received: isi field
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
          // untuk backend kirim email/upn (tidak ditampilkan di UI)
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

  // Placeholder kotak search
  $el.on('select2:open', () => {
    const inp = document.querySelector('.select2-container--open .select2-search__field');
    if (inp) inp.setAttribute('placeholder', 'Search...');
  });
}



function submitForm () {
  const apv = ($('#approved_select').select2('data') || [])[0] || {};

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
      // email tidak ditampilkan di UI, hanya dikirim; backend akan fallback ke Graph kalau kosong
      email:    (apv.email || apv.upn || '').trim()
    }
  };

  // Validasi minimal
  if (!payload.position)         return alert('Position wajib diisi');
  if (!payload.date)             return alert('Date wajib diisi');
  if (!payload.approver.ms_id)   return alert('Pilih Approver dari Azure');

  // cegah double-click
  const $btn = $('#btnSubmitVac').prop('disabled', true).text('Submitting...');

  // CSRF header (kalau CI4 CSRF aktif)
  const csrfHeader = {'X-CSRF-TOKEN': '<?= csrf_hash() ?>'};

  $.ajax({
    url: "<?= base_url('admin/vacancy/submit') ?>",
    method: 'POST',
    contentType: 'application/json',
    data: JSON.stringify(payload),
    headers: Object.assign({'X-Requested-With':'XMLHttpRequest'}, csrfHeader),
    success: function (res) {
      if (res && res.ok) {
        if (res.emailSent) {
          alert('Submitted! Email approval dikirim ke approver.');
        } else {
          let msg = 'Submitted, tapi email belum terkirim.';
          if (res.mailError) {
            msg += `\n[debug] status=${res.mailError.exception || ''}`;
          }
          msg += `\nSilakan kirim manual link ini:\n${res.approveUrl}`;
          alert(msg);
        }
      } else {
        alert('Gagal submit: ' + (res?.message || 'Unknown error'));
      }
    }

    });
  }
</script>

</body>
</html>
