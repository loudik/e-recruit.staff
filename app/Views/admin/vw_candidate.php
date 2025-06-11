
<?= view('layoutAdmin/header.php'); ?>
        <?= view('layoutAdmin/sidebar.php'); ?>
        <?= view('layoutAdmin/navbar.php'); ?>
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
                                    <li class="nav-item"><a href="<?= base_url('admin/administrator') ?>"><span class="fa fa-lock"></span>Reports</a></li>
                                    
                                    
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
                      <table class="table table-hover align-middle" id="tblcandidate">
                        <thead>
                          <tr>
                            <th><input type="checkbox" id="checkAll"></th>
                            <th style="width: 25%;">Name</th>
                            <th style="width: 40%;">Applied for</th>
                            <th style="width: 15%;">Status</th>
                            <th style="width: 15%;">Date</th>
                            <th style="width: 15%;">Action</th>
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
            <script type="text/javascript"> 


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
                        dom: 'Bfrtip',
                        responsive: true,
                        searching: true,
                        paging: true,
                      
                        data: data.data,
                        columnDefs: [{ defaultContent: "-", targets: "_all" }],
                        columns: [
                           {
                            data: 'id',
                            render: function (data, type, row) {
                              return `<input type="checkbox" class="row-check" value="${data}">`;
                            },
                            orderable: false
                          },
                          { data: 'fullname' },
                          { data: 'application' },
                          {
                            data: 'isstatus',
                            render: function (data) {
                              if (data === '1') {
                                return '<span class="badge rounded-pill bg-primary">Confirm</span>';
                              } else if (data === '2') {
                                return '<span class="badge rounded-pill bg-success">Approve</span>';
                              } else if (data === '3') {
                                return '<span class="badge rounded-pill bg-danger">Reject</span>';
                              } else {
                                return '<span class="badge badge-secondary">N/A</span>';
                              }
                            }
                          },
                          {
                            data: 'idt',
                            render: function(data) {

                              const date = new Date(data);
                              const year = date.getFullYear();
                              const month = ('0' + (date.getMonth() + 1)).slice(-2);
                              const day = ('0' + date.getDate()).slice(-2);
                              return `${year}${month}${day}`;
                            }
                          },
                          {
                            render: function (data, type, row) {
                              if (row.isstatus === '2' || row.isstatus === '3') {
                                return `
                                  <div style="display: flex; justify-content: center; white-space: nowrap;">
                                    <button title="Details" class="btn btn-sm btn-info" onclick="fn_detail(${row.id})">
                                      <span class="fa fa-info-circle"></span>
                                    </button>
                                  </div>

                                `;
                              }

                              return `
                                <div style="white-space: nowrap;">
                                  <button title="Edit" class="btn btn-sm btn-primary" onclick="fn_view(${row.id})">
                                    <span class="fa fa-eye"></span>
                                  </button>
                                  <button title="Delete" class="btn btn-sm btn-danger" onclick="fn_deletecandidate(${row.id})">
                                    <span class="fa fa-trash-o"></span>
                                  </button>
                                </div>
                              `;
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
                console.log("ID to view:", id);
                $('#editcandidateModal').modal('show');
                var basePath = "<?= base_url('admin/file/viewbyfilename/') ?>";
                 
                
                $.ajax({
                  url: "<?= base_url('admin/candidate/view') ?>",
                  type: "POST",
                  data: { id: id },
                  dataType: "json",
                  success: function (data) {
                    console.log("DEBUG FILES:", data.debug);
                    console.log(data.data.personalid);
                  
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
                console.log("ID to approve:", id);
                if (!id) {
                  alert('No ID found for approval.');
                  return;
                }
                if (confirm("Are you sure you want to approve this candidate?")) {
                  fn_approveCandidate(id);
                }

              }

              function fn_approveCandidate(id) {
                console.log("ID to approve:", id);
                if (!id) {
                  alert('No ID found for approval.');
                  return;
                }

                $.ajax({
                  url: "<?= base_url('admin/candidate/approve') ?>",
                  type: "POST",
                  data: { id: id},
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