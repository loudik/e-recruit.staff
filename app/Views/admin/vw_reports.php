<?= view('layoutAdmin/header.php'); ?>
        <?= view('layoutAdmin/sidebar.php'); ?>
        <?= view('layoutAdmin/navbar.php'); ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
    </div>
  

        <div class="pxp-dashboard-content">
            <div class="pxp-dashboard-content-header">
                <div class="pxp-nav-trigger navbar pxp-is-dashboard d-lg-none">
                    <a role="button" data-bs-toggle="offcanvas" data-bs-target="#pxpMobileNav" aria-controls="pxpMobileNav">
                        <div class="pxp-line-1"></div>
                        <div class="pxp-line-2"></div>
                        <div class="pxp-line-3"></div>
                    </a>
                    <div class="offcanvas offcanvas-start pxp-nav-mobile-container pxp-is-dashboard" tabindex="-1" id="pxpMobileNav">
                        <div class="offcanvas-header">
                            <div class="pxp-logo">
                                <a href="index.html" class="pxp-animate"><span style="color: var(--pxpMainColor)">A</span>NP</a>
                            </div>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <nav class="pxp-nav-mobile">
                                <ul class="navbar-nav justify-content-end flex-grow-1">
                                    <li class="pxp-dropdown-header">Admin tools</li>
                                    <li class="nav-item"><a href="<?= base_url('admin/dashboard') ?>"><span class="fa fa-home"></span>Dashboard</a></li>
                                    <!-- <li class="nav-item"><a href="</?= base_url('admin/profile') ?>"><span class="fa fa-pencil"></span>Edit Profile</a></li> -->
                                    <li class="nav-item"><a href="<?= base_url('admin/newjobs') ?>"><span class="fa fa-file-text-o"></span>New Job Offer</a></li>
                                    <li class="nav-item"><a href="<?= base_url('admin/managejobs') ?>"><span class="fa fa-briefcase"></span>Manage Jobs</a></li>
                                    <li class="nav-item"><a href="<?= base_url('admin/candidate') ?>"><span class="fa fa-user-circle-o"></span>Candidates</a></li>
                                    <li class="nav-item"><a href="<?= base_url('admin/reports') ?>"><span class="fa fa-lock"></span>Reports</a></li>
                                    
                                    
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <nav class="pxp-user-nav pxp-on-light">
                    <a href="<?= base_url('admin/newjobs') ?>" class="btn rounded-pill pxp-nav-btn">Post a Job</a>
                    <div class="dropdown pxp-user-nav-dropdown">
                         <a role="button" class="dropdown-toggle" data-bs-toggle="dropdown">
                          <div class="pxp-user-nav-avatar pxp-cover" 
                            style="background-image: url('<?= esc(session()->get('user_avatar') ?? base_url('assets/images/customer-4.png')) ?>');">
                          </div>
                          <div class="pxp-user-nav-name d-none d-md-block">
                            <?= esc(session()->get('name') ?? 'Guest User') ?>
                          </div>
                      </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                          <li><a class="dropdown-item" href="<?= site_url('logout') ?>">Logout</a></li>
                        </ul>
                    </div>
                </nav>
            </div>

            <div class="pxp-dashboard-content-details">
                <h1>Report</h1>
                <p class="pxp-text-light">Detailed list of candidates that applied for your job.</p>

                <div class="mt-4 mt-lg-5">
                    <div class="d-flex justify-content-right align-items-center gap-3 mb-4">
                        <div class="d-flex align-items-center gap-2">
                            <label for="filter-start" class="form-label mb-0">Start Period:</label>
                            <input type="month" id="filter-start" class="form-control form-control-sm" style="width: 140px;" placeholder="YYYY-MM" />
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <label for="filter-end" class="form-label mb-0">End Period:</label>
                            <input type="month" id="filter-end" class="form-control form-control-sm" style="width: 140px;" placeholder="YYYY-MM" />
                        </div>
                         <button class="btn btn-sm btn-primary" onclick="fn_getreport()">Apply</button>
                    </div>




                    <div class="table-responsive">
                      <table class="table table-hover align-middle" id="tblcandidate">
                        <thead>
                          <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 25%;">Name</th>
                            <th style="width: 40%;">Applied for</th>
                            <th style="width: 40%;">Category</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 25%;">Date</th>
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>
                  </div>
                </div>
            </div>


            <!-- Modal Edit -->
            <div class="modal fade" id="editcandidateModal" tabindex="-1" aria-labelledby="editcandidateModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                        <div class="pxp-dashboard-content-details">
                            <h1>View Candidate</h1>
                            <p class="pxp-text-light">Detail Data Candidate that Applied</p>
                            <div class="row mt-4 mt-lg-5">
                              <div class="col-md-6 col-xxl-6">
                                  <input type="hidden" id="idapprove" name="idapprove" value="" />
                                  <label for="jobs" class="form-label">Job title</label>
                                  <input type="text" id="jobs" name="jobs"class="form-control rounded-pill" disabled>
                              </div>
                              <div class="col-md-6 col-xxl-6">
                                <label for="pob" class="form-label">Fullnames</label>
                                <input type="text" id="fullname" name="fullname" class="form-control rounded-pill" disabled>
                              </div>
                              <div class="col-md-6 col-xxl-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" id="email" name="email" class="form-control rounded-pill" disabled>
                              </div>
                              <div class="col-md-6 col-xxl-6">
                                <label for="pob" class="form-label">Graduation Year</label>
                                <input type="text" id="graduation" name="graduation" class="form-control rounded-pill" disabled>
                              </div>
                              <div class="col-md-6 col-xxl-6">
                                <label for="educationlevel" class="form-label">education Level</label>
                                <input type="text" id="educationlevel" name="educationlevel" class="form-control rounded-pill" disabled>
                              </div>
                              <div class="col-md-6 col-xxl-6">
                                <label for="languague" class="form-label">Languague Skills</label>
                                <input type="text" id="language" name="language" class="form-control rounded-pill" disabled>
                              </div>
                              <div class="col-md-6 col-xxl-6">
                                <label for="pob" class="form-label">GPA</label>
                                <input type="text" id="gpa" name="gpa" class="form-control rounded-pill" disabled>
                              </div>                        
                              <div class="col-md-6 col-xxl-6">
                                <label for="sexo" class="form-label">Sexo</label>
                                <input type="text" id="sexo" name="sexo" class="form-control rounded-pill" disabled>
                              </div>
                              <div class="col-md-6 col-xxl-6">
                                <label for="pob" class="form-label">Address</label>
                                <input type="text" id="address" name="address" class="form-control rounded-pill" disabled>
                              </div>
                              <div class="col-md-6 col-xxl-6">
                                <label for="pob" class="form-label">Phone</label>
                                <input type="text" id="phone" name="phone" class="form-control rounded-pill" disabled>
                              </div>
                              <div class="col-xxl-12 mt-4 mb-4">
                                <label class="form-label fw-bold">Personal ID</label>
                                <iframe id="personalid_preview" width="100%" height="800px"></iframe>
                              </div>
                              <div class="col-xxl-12 mt-4 mb-4">
                                <label class="form-label fw-bold">Curriculum Vitae (CV)</label>
                                <iframe id="cv_preview" width="100%" height="800px"></iframe>
                              </div>
                              <div class="col-xxl-6">
                                <label class="form-label fw-bold">Diploma</label>
                                <iframe id="diploma_preview" width="100%" height="800px"></iframe>
                              </div>
                              <div class="col-xxl-6">
                                <label class="form-label fw-bold">Transcript</label>
                                <iframe id="transcript_preview" width="100%" height="800px"></iframe>
                              </div>
                              <div class="col-xxl-6">
                                <label class="form-label fw-bold">Cover Letter</label>
                                <iframe id="coverletter_preview" width="100%" height="800px"></iframe>
                              </div>
                            </div>
                            <div class="mt-4 mt-lg-5 text-center">
                              <button class="btn rounded-pill pxp-section-cta" onclick="fn_approve()">Approve</button>
                              <button class="btn rounded-pill pxp-section-cta bg-danger " onclick="fn_reject()">Reject</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>



              <!-- Modal Reason Reject -->
              <div class="modal fade" id="reasonRejectModal" tabindex="-1" aria-labelledby="reasonRejectLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title w-100 text-center mt-3" id="reasonRejectLabel">Reason for Rejection</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                      <input type="hidden" id="reject_id">
                      <div class="mb-3">
                        <textarea id="reason" class="form-control" rows="4" placeholder="Enter reason here..."></textarea>
                      </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                       <button id="btnSubmitReject" type="button" class="btn btn-danger" onclick="submitReject(this)">
                        <span class="default-text">Submit</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                      </button>

                    </div>
                  </div>
                </div>
              </div>


              <!-- Modal Details Candidate -->
              <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="editcandidateModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                        <div class="pxp-dashboard-content-details">
                            <h1>Detail Candidate</h1>
                            <p class="pxp-text-light">Detail Data Candidate that Applied</p>
                            <div class="row mt-4 mt-lg-5">
                              <div class="col-12 mt-4">
                                <label for="reason" class="form-label">Approval Reason</label>
                                <textarea id="detailreason" class="form-control rounded-3" rows="4" readonly>
                                </textarea>
                              </div>

                              <div class="col-md-6 col-xxl-6">
                                  <input type="hidden" id="detailidapprove" name="idapprove" value="" />
                                  <label for="jobs" class="form-label">Job title</label>
                                  <input type="text" id="detailjobs" name="jobs"class="form-control rounded-pill" disabled>
                              </div>
                              <div class="col-md-6 col-xxl-6">
                                <label for="pob" class="form-label">Fullnames</label>
                                <input type="text" id="detailfullname" name="fullname" class="form-control rounded-pill" disabled>
                              </div>
                              <div class="col-md-6 col-xxl-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" id="detailemail" name="email" class="form-control rounded-pill" disabled>
                              </div>
                              <div class="col-md-6 col-xxl-6">
                                <label for="pob" class="form-label">Graduation Year</label>
                                <input type="text" id="detailgraduation" name="graduation" class="form-control rounded-pill" disabled>
                              </div>
                              <div class="col-md-6 col-xxl-6">
                                <label for="educationlevel" class="form-label">education Level</label>
                                <input type="text" id="detaileducationlevel" name="educationlevel" class="form-control rounded-pill" disabled>
                              </div>
                              <div class="col-md-6 col-xxl-6">
                                <label for="languague" class="form-label">Languague Skills</label>
                                <input type="text" id="detaillanguage" name="language" class="form-control rounded-pill" disabled>
                              </div>
                              <div class="col-md-6 col-xxl-6">
                                <label for="pob" class="form-label">GPA</label>
                                <input type="text" id="detailgpa" name="gpa" class="form-control rounded-pill" disabled>
                              </div>                        
                              <div class="col-md-6 col-xxl-6">
                                <label for="sexo" class="form-label">Sexo</label>
                                <input type="text" id="detailsexo" name="sexo" class="form-control rounded-pill" disabled>
                              </div>
                              <div class="col-md-6 col-xxl-6">
                                <label for="pob" class="form-label">Address</label>
                                <input type="text" id="detailaddress" name="address" class="form-control rounded-pill" disabled>
                              </div>
                              <div class="col-md-6 col-xxl-6">
                                <label for="pob" class="form-label">Phone</label>
                                <input type="text" id="detailphone" name="phone" class="form-control rounded-pill" disabled>
                              </div>
                              <div class="col-xxl-12 mt-4 mb-4">
                                <label class="form-label fw-bold">Personal ID</label>
                                <iframe id="detailpersonalid_preview" width="100%" height="800px"></iframe>
                              </div>
                              <div class="col-xxl-12 mt-4 mb-4">
                                <label class="form-label fw-bold">Curriculum Vitae (CV)</label>
                                <iframe id="detailcv_preview" width="100%" height="800px"></iframe>
                              </div>
                              <div class="col-xxl-6">
                                <label class="form-label fw-bold">Diploma</label>
                                <iframe id="detaildiploma_preview" width="100%" height="800px"></iframe>
                              </div>
                              <div class="col-xxl-6">
                                <label class="form-label fw-bold">Transcript</label>
                                <iframe id="detailtranscript_preview" width="100%" height="800px"></iframe>
                              </div>
                              <div class="col-xxl-6">
                                <label class="form-label fw-bold">Cover Letter</label>
                                <iframe id="detailcoverletter_preview" width="100%" height="800px"></iframe>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>






            <?= view('layoutAdmin/footer.php'); ?>
              <!-- DataTables CSS -->
            <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
            <!-- Buttons extension CSS -->
            <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
            <!-- DataTables Buttons Bootstrap5 CSS -->
            <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet" />
            <!-- DataTables -->
            <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
            <script type="text/javascript"> 

            $.get("<?= base_url('admin/logo-base64') ?>", function (res) {
                logoBase64 = res.base64;
            });



          $(document).ready(function () {
            flatpickr("#filter-start", {
                plugins: [new monthSelectPlugin({ shorthand: true, dateFormat: "Y-m", theme: "light" })]
            });

            flatpickr("#filter-end", {
                plugins: [new monthSelectPlugin({ shorthand: true, dateFormat: "Y-m", theme: "light" })]
            });
            fn_getreport();
            $('#filter-start, #filter-end').on('change', fn_getreport);
          });



    function fn_getreport() {
          const start = $('#filter-start').val();
          const end = $('#filter-end').val();

          $.ajax({
              url: "<?= base_url('admin/report/getreport') ?>",
              type: "GET",
              data: { start, end },
              dataType: "json",
              success: function (data) {
                  if (data.response === 'success') {
                      if ($.fn.DataTable.isDataTable('#tblcandidate')) {
                          $('#tblcandidate').DataTable().clear().destroy();
                      }

                      $('#tblcandidate').DataTable({
                          dom: 'Bfrtip',
                          data: data.data,
                          buttons: [
                              {
                                  extend: 'excelHtml5',
                                  title: 'Candidate Report',
                                  exportOptions: {
                                      columns: [0,1,2,3,4,5,6,7,8,9,10,11,12]
                                  },
                                  customize: function (xlsx) {
                                    const sheet = xlsx.xl.worksheets['sheet1.xml'];
                                    const headers = [
                                        'No', 'Fullname', 'Application', 'Group', 'Unit', 'Status',
                                        'Phone', 'Email', 'Gender', 'Education Level', 'Graduation', 'GPA', 'Date'
                                    ];

                                    const firstRow = $('row', sheet).first();
                                    $('c', firstRow).each(function (i) {
                                        if (headers[i]) {
                                            const cell = $(this);
                                            const value = cell.find('v');
                                            if (value.length) value.text(headers[i]);
                                        }
                                    });
                                }

                              },
                              {
                                  extend: 'pdfHtml5',
                                  title: 'Candidate Report',
                                  orientation: 'landscape',
                                  pageSize: 'A4',
                                  exportOptions: {
                                      columns: [0,1,2,3,4,5,6,7,8,9,10,11,12]
                                  },
                                  customize: function (doc) {
                                      if (logoBase64) {
                                          doc.content.splice(0, 0, {
                                              image: logoBase64,
                                              width: 100,
                                              alignment: 'center',
                                              margin: [0, 0, 0, 10]
                                          });
                                      }

                                      doc.content.splice(1, 0, {
                                          text: 'Candidate Report - Exported',
                                          fontSize: 14,
                                          alignment: 'center',
                                          margin: [0, 0, 0, 10]
                                      });
                                  }
                              }
                          ],
                          columns: [
                              {
                                  data: null,
                                  render: (data, type, row, meta) => meta.row + 1,
                                  orderable: false,
                                  title: 'No'
                              },
                              { data: 'fullname', title: 'Fullname' },
                              { data: 'application', title: 'Application' },
                              { data: 'groupname', title: 'Group' },
                              { data: 'unitname', title: 'Unit' },
                              {
                                  data: 'isstatus',
                                  title: 'Status',
                                  render: function (data) {
                                      if (data === '1') return 'Confirm';
                                      if (data === '2') return 'Approve';
                                      if (data === '3') return 'Reject';
                                      return 'N/A';
                                  }
                              },
                              { data: 'phone', visible: false, title: 'Phone' },
                              { data: 'email', visible: false, title: 'Email' },
                              { data: 'sexo', visible: false, title: 'Gender' },
                              { data: 'educationlevel', visible: false, title: 'Education Level' },
                              { data: 'graduation', visible: false, title: 'Graduation' },
                              { data: 'gpa', visible: false, title: 'GPA' },
                              {
                                  data: 'idt',
                                  visible: false,
                                  title: 'Date',
                                  render: function (data) {
                                      const d = new Date(data);
                                      return `${String(d.getDate()).padStart(2, '0')}-${String(d.getMonth() + 1).padStart(2, '0')}-${d.getFullYear()}`;
                                  }
                              }
                          ]
                      });
                  } else {
                      alert('No data found');
                  }
              },
              error: function (xhr, status, error) {
                  console.error('AJAX error:', error);
              }
          });
      }
  </script>