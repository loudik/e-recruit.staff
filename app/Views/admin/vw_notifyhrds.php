

    <?= $this->extend('layoutAdmin/template') ?>
    <?= $this->section('content') ?>
        <!-- main body area -->
  

            <!-- Body: Body -->
            <div class="body d-flex py-3">
                <div class="container-xxl">
                    <div class="row align-items-center">
                        <div class="border-0 mb-4">
                            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                                <h3 class="fw-bold mb-0">HRDIS NOTIFICATION</h3>
                            </div>
                        </div>
                    </div> <!-- Row end  -->
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <table id="tblnotify" class="table table-striped w-100">
                                          <thead>
                                            <tr>
                                              <th>POSITION</th>
                                              <th>REQUESTER</th>
                                              <th>APPROVER</th>
                                              <th>RECEIVER</th>
                                              <th>APPROVED AT</th>
                                              <th>RECEIVED AT</th>
                                              <th>STATUS</th>
                                              <th>ACTION</th>
                                            </tr>
                                          </thead>
                                          <tbody></tbody>
                                        </table>
 

                                </div>
                            </div>
                        </div>
                    </div> <!-- Row end  -->
                </div>
            </div>
      





   <?= $this->endSection() ?>

<?= $this->section('scripts') ?>
 
    <script>
$(document).ready(function () {
  const $tbl = $('#tblnotify');

  // 1) Pastikan elemen ada
  if ($tbl.length === 0) {
    console.error('DOM: #tblnotify tidak ditemukan');
    return;
  }

  // 2) Init DataTable sekali
  let dt;
  if (!$.fn.DataTable.isDataTable($tbl)) {
    dt = $tbl.addClass('nowrap').DataTable({
      // sementara matikan responsive dulu untuk debug
      responsive: true,
      autoWidth: false,
      columnDefs: [{ targets: [-1, -3], className: 'dt-body-right' }],
      order: []
    });
  } else {
    dt = $tbl.DataTable();
  }

  fn_loadNotifyHRDS(dt);
});

function fn_loadNotifyHRDS(dt) {
  const apiUrl = '<?= base_url('admin/notifyhrds/loadnotify') ?>';

  $.ajax({
    url: apiUrl,
    type: 'GET',
    dataType: 'json',
    beforeSend: function (xhr) { xhr.setRequestHeader('X-Requested-With','XMLHttpRequest'); },
    success: function (res) {
      console.log('AJAX OK:', res);

      if (!res || !res.status) {
        console.warn('status=false atau response kosong:', res);
        return;
      }

      const baseView = '<?= base_url('admin/notifyhrds/loadnotify/view') ?>';

      // 3) Susun rows (8 kolom, sama dengan <thead>)
      const map = {0:'Pending',1:'Approved',2:'Received',3:'Verified'};
      const rows = (res.data || []).map(item => {
      const label = map[item.status] ?? item.status;
      const badge = `<span class="badge bg-${
          item.status==0?'warning':item.status==1?'primary':item.status==2?'info':'success'
      }">${label}</span>`;

      const viewUrl = baseView + '/' + encodeURIComponent(item.id);

      // kalau status = 3 (Verified) maka kosongkan tombol
      const actionBtn = (item.status == 3) 
          ? '' 
          : `<a href="${viewUrl}" class="btn btn-primary btn-sm">View</a>`;

      return [
        item.position ?? '-',
        item.req_name ?? '-',
        item.apvname ?? '-',
        item.recname ?? '-',
        item.approved_at ?? '-',
        item.received_at ?? '-',
        badge,
        actionBtn
      ];
    });


      console.log('Rows siap:', rows.length);
      dt.clear();
      if (rows.length) dt.rows.add(rows);
      dt.draw(false);
      if (dt.columns && dt.responsive) {
        try { dt.columns.adjust(); dt.responsive.recalc(); } catch(_) {}
      }
      if (dt.rows().count() === 0 && rows.length > 0) {
        console.warn('DT tidak render, fallback isi <tbody> manual');
        const html = rows.map(cols => `<tr>${cols.map(c=>`<td>${c}</td>`).join('')}</tr>`).join('');
        document.querySelector('#tblnotify tbody').innerHTML = html;
      }
    },
    error: function (xhr) {
      console.error('AJAX ERROR:', xhr.status, xhr.responseText);
      alert('Error fetching data.');
    }
  });
}

function viewVacancy(id) {
  if (!id) return alert('Invalid ID');
  $.ajax({
    url: '<?= base_url('admin/notifyhrds/loadnotify/view') ?>/' + encodeURIComponent(id),
    type: 'GET',
    dataType: 'html',
    beforeSend: function (xhr) { xhr.setRequestHeader('X-Requested-With','XMLHttpRequest'); },
    success: function (res) {
      // tampilkan di popup
      const w = window.open('', '_blank', 'width=800,height=600,scrollbars=yes');
      if (w) {
        w.document.write(res);
        w.document.close();
      } else {
        alert('Popup blocked. Please allow popups for this site.');
      }
    },
    error: function (xhr) {
      console.error('AJAX ERROR:', xhr.status, xhr.responseText);
      alert('Error loading vacancy details.');
    }
  });
}





</script>



<?= $this->endSection() ?>