
<?= view('layoutAdmin/header.php'); ?>
        <?= view('layoutAdmin/sidebar.php'); ?>
        <?= view('layoutAdmin/navbar.php'); ?>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
        <style>
          .dataTables_wrapper .dt-buttons {
  margin-bottom: 10px;
}

.table thead th {
  vertical-align: middle;
  text-align: center;
}

        </style>

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
                                   <?= session()->get('treemenu') ?? '' ?>
                                    
                                    
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
                <h1>Candidates</h1>
                <p class="pxp-text-light">Detailed list of candidates that applied for your job.</p>

                <div class="mt-4 mt-lg-5">
                    <div class="row justify-content-between align-content-center">
                        <div class="col-auto order-2 order-sm-1">
                            <div class="pxp-company-dashboard-jobs-bulk-actions mb-3">
                              <select class="form-select" id="bulkActionSelect">
                                  <option value="">Bulk actions</option>
                                  <option value="approve">Approve</option>
                                  <option value="reject">Reject</option>
                                  <option value="delete">Delete</option>
                              </select>
                              <button class="btn btn-primary ms-2" onclick="fn_applyBulk()">Apply</button>
                          </div>
                        </div>
           
                      </div>

                    <div class="table-responsive">
                      <table class="table table-hover align-middltable table-striped table-hover table-bordered nowrap w-100" id="tblcandidate">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Applied</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Review</th>
                            <th>Write</th>
                            <th>Interview</th>
                            <th>Total</th>
                            <th>Action</th>
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

                   <!-- Step 0: General Info -->
                    <div id="step-doc-0">
                      <h3>View Candidate</h3>
                      <p class="text-muted">Detail Data Candidate that Applied</p>
                      <div class="row">
                        <div class="col-md-6">
                          <input type="hidden" id="idapprove" name="idapprove" value="" />
                          <label for="jobs" class="form-label">Job title</label>
                          <input type="text" id="jobs" name="jobs" class="form-control rounded-pill" disabled>
                        </div>
                        <div class="col-md-6">
                          <label for="fullname" class="form-label">Fullnames</label>
                          <input type="text" id="fullname" name="fullname" class="form-control rounded-pill" disabled>
                        </div>
                        <div class="col-md-6">
                          <label for="email" class="form-label">Email</label>
                          <input type="text" id="email" name="email" class="form-control rounded-pill" disabled>
                        </div>
                        <div class="col-md-6">
                          <label for="graduation" class="form-label">Graduation Year</label>
                          <input type="text" id="graduation" name="graduation" class="form-control rounded-pill" disabled>
                        </div>
                        <div class="col-md-6">
                          <label for="educationlevel" class="form-label">Education Level</label>
                          <input type="text" id="educationlevel" name="educationlevel" class="form-control rounded-pill" disabled>
                        </div>
                        <div class="col-md-6">
                          <label for="language" class="form-label">Language Skills</label>
                          <input type="text" id="language" name="language" class="form-control rounded-pill" disabled>
                        </div>
                        <div class="col-md-6">
                          <label for="sexo" class="form-label">Sexo</label>
                          <input type="text" id="sexo" name="sexo" class="form-control rounded-pill" disabled>
                        </div>
                        <div class="col-md-6">
                          <label for="address" class="form-label">Address</label>
                          <input type="text" id="address" name="address" class="form-control rounded-pill" disabled>
                        </div>
                        <div class="col-md-6">
                          <label for="phone" class="form-label">Phone</label>
                          <input type="text" id="phone" name="phone" class="form-control rounded-pill" disabled>
                        </div>
                      </div>
                      <div class="mt-4 text-end">
                        <button class="btn btn-sm btn-primary" onclick="showDocStep(1)">Next</button>
                      </div>
                    </div>

                    <!-- Step 1: GPA -->
                    <div id="step-doc-1" class="d-none">
                      <h3>Step 1: GPA</h3>
                      <p class="text-muted">Please check GPA and assign score</p>
                      <div class="row">
                        <div class="col-md-6">
                          <label for="gpa" class="form-label">GPA</label>
                          <input type="text" id="gpa" name="gpa" class="form-control rounded-pill" disabled>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Point</label>
                          <input type="number" id="point_gpa" name="point_gpa" class="form-control" style="width: 100px;" min="0" max="12" value="0" oninput="updateTotalPoint()">
                        </div>
                      </div>
                      <div class="mt-4 text-end">
                        <button class="btn btn-sm btn-secondary" onclick="showDocStep(0)">Back</button>
                        <button class="btn btn-sm btn-primary" onclick="showDocStep(2)">Next</button>
                      </div>
                    </div>

                    <!-- Step 2: Personal ID -->
                    <div id="step-doc-2" class="d-none">
                      <h3>Step 2: Personal ID</h3>
                      <iframe id="personalid_preview" width="100%" height="800px"></iframe>
                      <label class="form-label mt-2">Point</label>
                      <input type="number" id="point_personalid" name="point_personalid" class="form-control" style="width: 100px;" min="0" max="12" value="0" oninput="updateTotalPoint()">
                      <div class="mt-4 text-end">
                        <button class="btn btn-sm btn-secondary" onclick="showDocStep(1)">Back</button>
                        <button class="btn btn-sm btn-primary" onclick="showDocStep(3)">Next</button>
                      </div>
                    </div>

                    <!-- Step 3: Curriculum Vitae -->
                    <div id="step-doc-3" class="d-none">
                      <h3>Step 3: Curriculum Vitae (CV)</h3>
                      <iframe id="cv_preview" width="100%" height="800px"></iframe>
                      <label class="form-label mt-2">Point</label>
                      <input type="number" id="point_cv" name="point_cv" class="form-control" style="width: 100px;" min="0" max="12" value="0" oninput="updateTotalPoint()">
                      <div class="mt-4 text-end">
                        <button class="btn btn-sm btn-secondary" onclick="showDocStep(2)">Back</button>
                        <button class="btn btn-sm btn-primary" onclick="showDocStep(4)">Next</button>
                      </div>
                    </div>

                    <!-- Step 4: Diploma -->
                    <div id="step-doc-4" class="d-none">
                      <h3>Step 4: Diploma</h3>
                      <iframe id="diploma_preview" width="100%" height="800px"></iframe>
                      <label class="form-label mt-2">Point</label>
                      <input type="number" id="point_diploma" name="point_diploma" class="form-control" style="width: 100px;" min="0" max="12" value="0" oninput="updateTotalPoint()">
                      <div class="mt-4 text-end">
                        <button class="btn btn-sm btn-secondary" onclick="showDocStep(3)">Back</button>
                        <button class="btn btn-sm btn-primary" onclick="showDocStep(5)">Next</button>
                      </div>
                    </div>

                    <!-- Step 5: Transcript -->
                    <div id="step-doc-5" class="d-none">
                      <h3>Step 5: Transcript</h3>
                      <iframe id="transcript_preview" width="100%" height="800px"></iframe>
                      <label class="form-label mt-2">Point</label>
                      <input type="number" id="point_transcript" name="point_transcript" class="form-control" style="width: 100px;" min="0" max="12" value="0" oninput="updateTotalPoint()">
                      <div class="mt-4 text-end">
                        <button class="btn btn-sm btn-secondary" onclick="showDocStep(4)">Back</button>
                        <button class="btn btn-sm btn-primary" onclick="showDocStep(6)">Next</button>
                      </div>
                    </div>

                    <!-- Step 6: Cover Letter -->
                    <div id="step-doc-6" class="d-none">
                      <h3>Step 6: Cover Letter</h3>
                      <iframe id="coverletter_preview" width="100%" height="800px"></iframe>
                      <div class="mt-3">
                        <label class="form-label">Point</label>
                        <input type="number" id="point_coverletter" name="point_coverletter"
                          class="form-control" style="width: 100px;" min="0" max="12" value="0" oninput="updateTotalPoint()">
                        <div class="fw-bold mt-4">
                          Total Point: <span id="totalPoint">0</span>
                        </div>
                      </div>
                      <div class="mt-4 text-center">
                        <button class="btn btn-success" onclick="fn_approve()">Approve</button>
                        <button class="btn btn-danger" onclick="fn_reject()">Reject</button>
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
                                  <input type="hidden" id="detailidapprove" name="detailidapprove" value="" />
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
            <script type="text/javascript"> 

             let currentDocStep = 0;
             const totalSteps = 6;

              function showDocStep(step) {
                for (let i = 0; i <= totalSteps; i++) {
                  const section = document.getElementById(`step-doc-${i}`);
                  if (section) {
                    section.classList.add('d-none');
                  }
                }
                const activeStep = document.getElementById(`step-doc-${step}`);
                if (activeStep) {
                  activeStep.classList.remove('d-none');
                  currentDocStep = step;
                }
              }

              function updateTotalPoint(){
                const total =
                  getPoint('point_gpa') +
                  getPoint('point_personalid') +
                  getPoint('point_cv') +
                  getPoint('point_diploma') +
                  getPoint('point_transcript') +
                  getPoint('point_coverletter');
                document.getElementById('totalPoint').innerText = total;
              }

              function getPoint(id) {
                const input = document.getElementById(id);
                const val = parseInt(input?.value);
                return isNaN(val) ? 0 : val;
              }

              function autoEvaluateGPA() {
                const gpaVal = parseFloat(document.getElementById("gpa").value);
                const gpaPoint = document.getElementById("point_gpa");
                if (!isNaN(gpaVal)) {
                  if (gpaVal >= 3.0) gpaPoint.value = 12;
                  else if (gpaVal >= 2.5) gpaPoint.value = 10;
                  else gpaPoint.value = 5;
                }
              }

              function checkIfExistsAndSetPoint(frameId, pointInputId) {
                const frame = document.getElementById(frameId);
                const pointInput = document.getElementById(pointInputId);
                if (frame && frame.src && frame.src !== '' && !frame.src.endsWith('/')) {
                  pointInput.value = 12;
                }
              }

              document.addEventListener("DOMContentLoaded", function () {
                autoEvaluateGPA();
                checkIfExistsAndSetPoint("personalid_preview", "point_personalid");
                checkIfExistsAndSetPoint("diploma_preview", "point_diploma");
                checkIfExistsAndSetPoint("transcript_preview", "point_transcript");
                updateTotalPoint();
                [
                  'point_gpa',
                  'point_personalid',
                  'point_cv',
                  'point_diploma',
                  'point_transcript',
                  'point_coverletter'
                ].forEach(id => {
                  const el = document.getElementById(id);
                  if (el) {
                    el.addEventListener('input', updateTotalPoint);
                  }
                });
              });


              $(document).ready(function(){
                fn_getcandidate();
              })

              function fn_getcandidate() {
                $.ajax({
                  url: "<?= base_url('admin/candidate/getcandidate') ?>",
                  type: "GET",
                  dataType: "json",
                  success: function (data) {
                    if (data.response === 'success') {
                      $('.pxp-company-dashboard-jobs-search-results').text(`${data.data.length} candidates`);
                      if ($.fn.DataTable.isDataTable('#tblcandidate')) {
                        $('#tblcandidate').DataTable().clear().destroy();
                      }
                      // Inisialisasi ulang DataTable
                      let table = $('#tblcandidate').DataTable({
                        dom: '<"d-flex justify-content-between align-items-center mb-3"Bf>rt<"d-flex justify-content-between align-items-center mt-2"lip>',
                        responsive: true,
                        scrollX: true,
                        buttons: [
                          { extend: 'excelHtml5', className: 'btn btn-success btn-sm me-1' },
                          { extend: 'csvHtml5', className: 'btn btn-primary btn-sm me-1' },
                          { extend: 'pdfHtml5', className: 'btn btn-danger btn-sm' }
                        ],
                        data: data.data,
                        columnDefs: [{ defaultContent: "-", targets: "_all" }],
                        columns: [
                          {
                            data: null,
                            className: 'text-center',
                            render: (data, type, row, meta) => meta.row + 1,
                            title: 'No',
                            orderable: false
                          },
                          { data: 'fullname'
                          },
                          { data: 'application'},
                          {
                            data: 'isstatus',
                            className: 'text-center',
                            render: function (data) {
                              if (data === '1') return '<span class="badge bg-primary">Confirm</span>';
                              if (data === '2') return '<span class="badge bg-success">Approve</span>';
                              if (data === '3') return '<span class="badge bg-danger">Reject</span>';
                              return '<span class="badge bg-secondary">N/A</span>';
                            },
                            // title: 'Status'
                          },
                          {
                            data: 'idt',
                            className: 'text-center',
                            render: function (data) {
                              const date = new Date(data);
                              return `${date.getFullYear()}${String(date.getMonth() + 1).padStart(2, '0')}${String(date.getDate()).padStart(2, '0')}`;
                            },
                            // title: 'Date'
                          },
                          {
                            data: 'reviewpoint',
                            className: 'text-center',
                            // title: 'Review',
                            render: function (data) {
                              return data ? data : '0';
                            }
                          },
                          {
                            data: 'writepoint',
                            className: 'text-center',
                            // title: 'Write',
                            render: function (data) {
                              return data ? data : '0';
                            }
                          },
                          {
                            data: 'interviewpoint',
                            className: 'text-center',
                            // title: 'Interview',
                            render: function (data) {
                              return data ? data : '0';
                            }
                          },
                          {
                            data: 'totalpoint',
                            className: 'text-center',
                            // title: 'Total',
                            render: function (data) {
                              return data ? data : '0';
                            }
                          },
                          {
                            className: 'text-center',
                            title: 'Action',
                            render: function (data, type, row) {
                              const viewBtn = `<button class="btn btn-sm btn-primary me-1" title="View" onclick="fn_view(${row.id})"><i class="fa fa-eye"></i></button>`;
                              const delBtn = `<button class="btn btn-sm btn-danger" title="Delete" onclick="fn_deletecandidate(${row.id})"><i class="fa fa-trash"></i></button>`;
                              const detailBtn = `<button class="btn btn-sm btn-info" title="Details" onclick="fn_detail(${row.id})"><i class="fa fa-info-circle"></i></button>`;

                              return row.isstatus === '2' || row.isstatus === '3'
                                ? detailBtn
                                : viewBtn + delBtn;
                            }
                          }
                        ]
                      });

                      
                      $('#searchInput').off('keyup').on('keyup', function () {
                        table.column(0).search(this.value).draw();
                      });

                      $('#tblcandidate_filter input')
                        .addClass('form-control-sm')     
                        .css('width', '180px');       

                        $('#tblcandidate_paginate .paginate_button')
                          .addClass('btn btn-sm');

                        $('#tblcandidate_info')
                          .addClass('small');

                        $('#tblcandidate_paginate')
                          .addClass('d-flex gap-1');
                        
                        $('#checkAll').on('change', function () {
                          $('.row-check').prop('checked', this.checked);
                          $('#bulkApplyBtn').prop('disabled', $('.row-check:checked').length === 0);
                        });

                        $('#bulkApplyBtn').prop('disabled', true); // awalnya nonaktif
                        $(document).on('change', '.row-check', function () {
                          $('#bulkApplyBtn').prop('disabled', $('.row-check:checked').length === 0);
                        });
                       
                    } else {
                      alert('No data found');
                    }
                  },
                  error: function (xhr, status, error) {
                    console.error('AJAX Error:', error);
                  }
                });
              }

              function fn_view(id) {
                $('#editcandidateModal').modal('show');
                var basePath = "<?= base_url('admin/file/viewbyfilename/') ?>";
                
                $.ajax({
                  url: "<?= base_url('admin/candidate/view') ?>",
                  type: "POST",
                  data: { id: id },
                  dataType: "json",
                  success: function (data) {
                    console.log("Response data:", data);
                    if (data.response === 'success') {
                     
                      $('#cv_preview').attr('src', basePath + data.data.cv);
                      $('#diploma_preview').attr('src', basePath + data.data.diploma);
                      $('#transcript_preview').attr('src', basePath + data.data.transcript);
                      $('#coverletter_preview').attr('src', basePath + data.data.coverletter);
                      $('#personalid_preview').attr('src', basePath + data.data.personalid);

                      $('#idapprove').val(data.data.id); 
                      $('#jobs').val(data.data.application);
                      $('#fullname').val(data.data.fullname);
                      $('#email').val(data.data.email);
                      $('#graduation').val(data.data.graduation);
                      $('#educationlevel').val(data.data.educationlevel);
                      $('#language').val(data.data.language);
                      $('#gpa').val(data.data.gpa);
                      $('#dob').val(data.data.dob);
                      $('#pob').val(data.data.pob);
                      $('#address').val(data.data.address);
                      $('#phone').val(data.data.phone);
                      $('#sexo').val(data.data.sexo);
                      $('#editcandidateModal').modal('show');
                    } else {
                      alert('No data found');
                    }
                  },
                  error: function (xhr, status, error) {
                    console.error('AJAX Error:', error);
                  }
                });
              }

              function fn_approve() {
                const id = $('#idapprove').val();
                console.log("Value of #idapprove:", id); 
                const totalPoint = $('#totalPoint').text();
                
                if (!id) {
                  alert('No ID found for approval.');
                  return;
                }
                if (confirm("Are you sure you want to approve this candidate?")) {
                  fn_approveCandidate(id, totalPoint);
                }

              }

              function fn_approveCandidate(id,totalPoint) {
                if (!id) {
                  alert('No ID found for approval.');
                  return;
                }

                $.ajax({
                  url: "<?= base_url('admin/candidate/approve') ?>",
                  type: "POST",
                  data: { 
                    id: id,
                    total_point: totalPoint 
                  },
                  dataType: "json",
                  success: function (data) {
                    
                    if (data.response === 'success') {
                      alert('Candidate approved successfully!');
                      $('#editcandidateModal').modal('hide');
                      window.location.href = "<?= base_url('admin/candidate') ?>";
                    } else {
                      alert('Failed to approve candidate.');
                    }
                  },
                  error: function (xhr, status, error) {
                    console.error('AJAX Error:', error);
                  }
                });
              }
                
                

              function fn_reject() {
                const id = $('#idapprove').val();
                console.log("ID to reject:", id);
                if (!id) {
                  alert('No ID found for rejection.');
                  return;
                }
                // Set ID ke modal
                $('#reject_id').val(id);
                // Tampilkan modal
                $('#reasonRejectModal').modal('show');
                $('#editcandidateModal').modal('hide');
              }

              function submitReject(button) {
                const id = $('#reject_id').val();
                const reason = $('#reason').val().trim();

                if (!reason) {
                  alert('Please provide a reason for rejection.');
                  return;
                }
                const defaultText = button.querySelector('.default-text');
                const spinner = button.querySelector('.spinner-border');
                button.disabled = true;
                defaultText.classList.add('d-none');
                spinner.classList.remove('d-none');

                $.ajax({
                  url: "<?= base_url('admin/candidate/reject') ?>",
                  type: "POST",
                  data: { id: id, reason: reason },
                  dataType: "json",
                  success: function (data) {
                    if (data.response === 'success') {
                      alert('Candidate rejected successfully.');
                      $('#reasonRejectModal').modal('hide');
                      $('#editcandidateModal').modal('hide');
                      window.location.href = "<?= base_url('admin/candidate') ?>";
                    } else {
                      alert('Failed to reject candidate.');
                      resetButton();
                    }
                  },
                  error: function (xhr, status, error) {
                    console.error('AJAX Error:', error);
                    alert('An error occurred.');
                    resetButton();
                  }
                });

                function resetButton() {
                  // Reset tombol ke kondisi awal
                  button.disabled = false;
                  defaultText.classList.remove('d-none');
                  spinner.classList.add('d-none');
                }
              }




              function fn_deletecandidate(id) {
                  if (confirm("Are you sure you want to delete this job?")) {
                      $.ajax({
                          url: '<?= base_url('admin/candidate/deletecandidate') ?>', 
                          type: 'POST',
                          data: { id: id },
                          success: function(response) {
                              if (response.response === 'success') {
                                  alert('Job deleted successfully');
                                  window.location.href = "<?= base_url('admin/managejobs') ?>"; 
                              } else {
                                  alert('Failed to delete job');
                              }
                          },
                          error: function(xhr, status, error) {
                              console.error('AJAX Error:', error);
                              alert('An error occurred while deleting the job');
                          }
                      });
                  }
              }

              function fn_detail(id) {
                console.log("Candidate ID:", id);
                const basePath = "<?= base_url('admin/file/viewbyfilename/') ?>";

                $.ajax({
                  url: "<?= base_url('admin/candidate/detail') ?>" ,
                  type: "POST",
                  data: { id: id },
                  dataType: "json",
                  success: function (data) {
                    console.log(data);
                    if (data.response === 'success') {
                      const c = data.data;

                      console.log(c.reason);
                      // Isi semua input
                      $('#detailidapprove').val(c.id);
                      $('#detailjobs').val(c.jobs);
                      $('#detailfullname').val(c.fullname);
                      $('#detailemail').val(c.email);
                      $('#detailgraduation').val(c.graduation);
                      $('#detaileducationlevel').val(c.educationlevel);
                      $('#detaillanguage').val(c.language);
                      $('#detailgpa').val(c.gpa);
                      $('#detailsexo').val(c.sexo);
                      $('#detailaddress').val(c.address);
                      $('#detailphone').val(c.phone);
                      $('#detailreason').val(c.reason);

                      $('#detailcv_preview').attr('src', basePath + c.cv);
                      $('#detaildiploma_preview').attr('src', basePath + c.diploma);
                      $('#detailtranscript_preview').attr('src', basePath + c.transcript);
                      $('#detailcoverletter_preview').attr('src', basePath + c.coverletter);
                      $('#detailpersonalid_preview').attr('src', basePath + c.personalid);

                      $('#detailModal').modal('show');
                    } else {
                      alert('Data not found.');
                    }
                  },
                  error: function (xhr, status, error) {
                    console.error('AJAX Error:', error);
                    alert('Failed to fetch details.');
                  }
                });
              }


              function fn_applyBulk() {
                const action = $('#bulkCandidateAction').val();
                const selectedIds = $('.row-check:checked').map(function () {
                  return $(this).val();
                }).get();

                if (!action || selectedIds.length === 0) {
                  alert('Pilih aksi dan minimal satu kandidat!');
                  return;
                }

                $.ajax({
                  url: "<?= base_url('admin/candidate/action') ?>",
                  type: "POST",
                  data: JSON.stringify({
                    action: action,
                    ids: selectedIds
                  }),
                  contentType: "application/json",
                  dataType: "json",
                  success: function (res) {
                    if (res.status === 'success') {
                      alert('Berhasil diproses!');
                      fn_getcandidate(); // reload ulang tabel
                    } else {
                      alert('Gagal: ' + res.message);
                    }
                  },
                  error: function (xhr, status, error) {
                    console.error('AJAX Error:', error);
                  }
                });
              }

              


              
            </script>