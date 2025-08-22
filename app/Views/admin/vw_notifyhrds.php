

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
                                          <th>Position</th>
                                          <th>Requester</th>
                                          <th>Approver</th>
                                          <th>Receiver</th>
                                          <th>Approved At</th>
                                          <th>Received At</th>
                                          <th>Status</th>
                                          <th>Action</th>
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

    <!-- Jquery Page Js -->
    <script src="<?= base_url('assets/js/template.js') ?>"></script>
    <script>
      $(document).ready(function () {
        // Cek elemen tabel
        if ($('#tblnotify').length === 0) {
          console.error('Tabel #tblnotify tidak ditemukan di DOM!');
          return;
        }

        // Inisialisasi DataTable sekali
        if (!$.fn.DataTable.isDataTable('#tblnotify')) {
          $('#tblnotify')
            .addClass('nowrap')
            .DataTable({
              responsive: true,
              columnDefs: [{ targets: [-1, -3], className: 'dt-body-right' }],
              order: []
            });
        } else {
          console.warn('DataTable sudah ada, skip init.');
        }

        fn_loadNotifyHRDS();
      });

      function fn_loadNotifyHRDS() {
        $.ajax({
          url: '<?= base_url('admin/notifyhrds/loadnotify') ?>',  // pastikan route kamu memang /admin/...
          type: 'GET',
          dataType: 'json',
          beforeSend: function (xhr) {
            xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
          },
          success: function (res) {
            console.log('AJAX OK:', res);

            if (!res || !res.status) {
              console.warn('Backend balas status=false:', res);
              return;
            }

            // Siapkan rows (8 kolom)
            const rows = (res.data || []).map(item => {
              const map = {0:'Pending',1:'Approved',2:'Received',3:'Verified'};
              const label = map[item.status] ?? item.status;
              const badge =
                `<span class="badge bg-${
                  item.status==0?'warning':item.status==1?'primary':item.status==2?'info':'success'
                }">${label}</span>`;

              return [
                item.position ?? '-',
                item.req_name ?? '-',
                item.apvname ?? '-',
                item.recname ?? '-',
                item.approved_at ?? '-',
                item.received_at ?? '-',
                badge,
                `<a href="<?= base_url('admin/vacancyverify/signature/') ?>${item.id}" class="btn btn-primary btn-sm">View</a>`
              ];
            });

            console.log('Rows siap ditambahkan:', rows.length);

            // Render ke DataTables
            try {
              const table = $('#tblnotify').DataTable();
              table.clear();
              table.rows.add(rows).draw(false);

              console.log('Rows dalam DT setelah draw:', table.rows().count());

              // Fallback: kalau karena suatu alasan DT tidak render, isi <tbody> manual untuk memastikan kelihatan
              if (table.rows().count() === 0 && rows.length > 0) {
                console.warn('DataTables tidak menampilkan row, fallback isi <tbody> manual.');
                const tbody = document.querySelector('#tblnotify tbody');
                tbody.innerHTML = rows.map(cols => `<tr>${cols.map(c => `<td>${c}</td>`).join('')}</tr>`).join('');
              }
            } catch (e) {
              console.error('Gagal akses DataTables API, fallback isi <tbody> manual. Error:', e);
              const tbody = document.querySelector('#tblnotify tbody');
              tbody.innerHTML = rows.map(cols => `<tr>${cols.map(c => `<td>${c}</td>`).join('')}</tr>`).join('');
            }
          },
          error: function (xhr) {
            console.error('AJAX ERROR:', xhr.status, xhr.responseText);
            alert('Error fetching data.');
          }
        });
      }
  </script>


