
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
                                    <li class="nav-item"><a href="<?= base_url('admin/profile') ?>"><span class="fa fa-pencil"></span>Edit Profile</a></li>
                                    <li class="nav-item"><a href="<?= base_url('admin/newjobs') ?>"><span class="fa fa-file-text-o"></span>New Job Offer</a></li>
                                    <li class="nav-item"><a href="<?= base_url('admin/managejobs') ?>"><span class="fa fa-briefcase"></span>Manage Jobs</a></li>
                                    <li class="nav-item"><a href="<?= base_url('admin/candidate') ?>"><span class="fa fa-user-circle-o"></span>Candidates</a></li>
                                    <li class="nav-item"><a href="<?= base_url('admin/changepw') ?>"><span class="fa fa-lock"></span>Change Password</a></li>
                                    <li class="pxp-dropdown-header mt-4">Insights</li>
                                    <li class="nav-item">
                                        <a href="company-dashboard-inbox.html" class="d-flex justify-content-between align-items-center">
                                            <div><span class="fa fa-envelope-o"></span>Inbox</div>
                                            <span class="badge rounded-pill">14</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="company-dashboard-notifications.html" class="d-flex justify-content-between align-items-center">
                                            <div><span class="fa fa-bell-o"></span>Notifications</div>
                                            <span class="badge rounded-pill">5</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <nav class="pxp-user-nav pxp-on-light">
                    <a href="company-dashboard-new-job.html" class="btn rounded-pill pxp-nav-btn">Post a Job</a>
                    <div class="dropdown pxp-user-nav-dropdown">
                        <a role="button" class="dropdown-toggle" data-bs-toggle="dropdown">
                            <div class="pxp-user-nav-avatar pxp-cover" style="background-image: url(images/company-logo-1.png);"></div>
                            <div class="pxp-user-nav-name d-none d-md-block">Artistre Studio</div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="company-dashboard.html">Dashboard</a></li>
                            <li><a class="dropdown-item" href="company-dashboard-profile.html">Edit profile</a></li>
                            <li><a class="dropdown-item" href="index.html">Logout</a></li>
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
                                <select class="form-select">
                                    <option>Bulk actions</option>
                                    <option>Approve</option>
                                    <option>Reject</option>
                                    <option>Delete</option>
                                </select>
                                <button class="btn ms-2">Apply</button>
                            </div>
                        </div>
                        <div class="col-auto order-1 order-sm-2">
                          <div class="pxp-company-dashboard-jobs-search mb-3">
                            <div class="input-group">
                              <label for="filter-period" class="form-label mb-0 me-2">Filter Period:</label>
                              <input type="month" id="filter-period" class="form-control form-control-sm" />
                            </div>
                          </div>
                        </div>
                      </div>

                    <div class="table-responsive">
                      <table class="table table-hover align-middle" id="tblcandidate">
                        <thead>
                          <tr>
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
                    <!-- <div class="modal-body"> -->
                        <div class="pxp-dashboard-content-details">
                            <h1>View Candidate</h1>
                            <p class="pxp-text-light">Detail Data Candidate that Applied</p>
                            <div class="row mt-4 mt-lg-5">
                              <div class="col-md-6 col-xxl-6">

                                  <!-- <input type="hidden" id="jobid" name="jobid" value="</?= $job['id']; ?>" /> -->
                                    <label for="jobs" class="form-label">Job title</label>
                                    <input type="text" id="jobs" name="jobs"class="form-control rounded-pill">
                
                              </div>
                     
                              <div class="col-md-6 col-xxl-6">
                                <label for="pob" class="form-label">Fullnames</label>
                                <input type="text" id="fullname" name="fullname" class="form-control rounded-pill">
                              </div>
                              <div class="col-md-6 col-xxl-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" id="email" name="email" class="form-control rounded-pill">
                              </div>
                              <div class="col-md-6 col-xxl-6">
                                <label for="pob" class="form-label">Graduation Year</label>
                                <input type="text" id="graduation" name="graduation" class="form-control rounded-pill">
                              </div>
                              <div class="col-md-6 col-xxl-6">
                                <div class="mb-3">
                                  <label for="educationlevel" class="form-label">education Level</label>
                                  <select id="educationlevel" name="educationlevel" class="form-select rounded-pill">
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-6 col-xxl-6">
                                <div class="mb-3">
                                  <label for="sexo" class="form-label">Languague Skills</label>
                                  <select id="language" name="languague" class="form-select rounded-pill">
                                    <option value="Good">Good</option>
                                    <option value="Average">Average</option>
                                    <option value="Bad">Bad</option>
                                    <option value="Very Bad">Very Bad</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-6 col-xxl-6">
                                <label for="pob" class="form-label">GPA</label>
                                <input type="text" id="gpa" name="gpa" class="form-control rounded-pill">
                              </div>                        
                              <div class="col-md-6 col-xxl-6">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" id="dob" name="dob" class="form-control rounded-pill" value="<?= date('Y-m-d') ?>">
                              </div>
                              <div class="col-md-6 col-xxl-6">
                                <label for="pob" class="form-label">Place of Birth</label>
                                <input type="text" id="pob" name="pob" class="form-control rounded-pill">
                              </div>
                              <div class="col-md-6 col-xxl-6">
                                <div class="mb-3">
                                  <label for="sexo" class="form-label">Sexo</label>
                                  <select id="sexo" name="sexo" class="form-select rounded-pill">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-6 col-xxl-6">
                                <label for="pob" class="form-label">Address</label>
                                <input type="text" id="address" name="address" class="form-control rounded-pill">
                              </div>
                              <div class="col-md-6 col-xxl-6">
                                <label for="pob" class="form-label">Phone</label>
                                <input type="text" id="phone" name="phone" class="form-control rounded-pill">
                              </div>
                              <div class="col-xxl-6">
                                <label class="form-label">Curriculum Vitae (CV)</label>
                                <iframe id="cv_preview" width="100%" height="300px"></iframe>
                              </div>
                              <div class="col-xxl-6">
                                <label class="form-label">Diploma</label>
                                <iframe id="diploma_preview" width="100%" height="300px"></iframe>
                              </div>
                              <div class="col-xxl-6">
                                <label class="form-label">Transcript</label>
                                <iframe id="transcript_preview" width="100%" height="300px"></iframe>
                              </div>
                              <div class="col-xxl-6">
                                <label class="form-label">Cover Letter</label>
                                <iframe id="coverletter_preview" width="100%" height="300px"></iframe>
                              </div>

                            </div>
                            <div class="mt-4 mt-lg-5">
                              <button class="btn rounded-pill pxp-section-cta" onclick="fn_approve()">Approve</button>
                              <button class="btn rounded-pill pxp-section-cta-o ms-3" onclick="fn_cancel()">Cancel</button>
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
            <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
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
                          { data: 'fullname' },
                          { data: 'application' },
                          {
                            data: 'isstatus',
                            render: function (data) {
                              if (data === '1') {
                                return '<span class="badge rounded-pill bg-primary">Confirm</span>';
                              } else if (data === '2') {
                                return '<span class="badge rounded-pill bg-success">Approve</span>';
                              } else {
                                return '<span class="badge badge-secondary">N/A</span>';
                              }
                            }
                          },
                          {
                            data: 'idt',
                            render: function(data) {
                              // Menggunakan Date untuk format YYYYMMDD
                              const date = new Date(data);
                              const year = date.getFullYear();
                              const month = ('0' + (date.getMonth() + 1)).slice(-2);
                              const day = ('0' + date.getDate()).slice(-2);
                              return `${year}${month}${day}`; // Format YYYYMMDD
                            }
                          },
                          {
                            render: function (data, type, row) {
                              return `
                                <div style="white-space: nowrap;">
                                  <button title="Edit" class="btn btn-sm btn-primary" onclick="fn_view(${row.id})"><span class="fa fa-pencil"></span> </button>
                                  <button title="Reject" class="btn btn-sm btn-warning"><span class="fa fa-ban"></span></button>
                                  <button title="Delete" class="btn btn-sm btn-danger" onclick="fn_deletecandidate(${row.id})"><span class="fa fa-trash-o"></span></button>
                                </div>
                              `;
                            }
                          }
                        ]
                      });

                      // Hubungkan input pencarian ke kolom nama
                      $('#searchInput').off('keyup').on('keyup', function () {
                        table.column(0).search(this.value).draw();
                      });

                      $('#tblcandidate_filter input')
                        .addClass('form-control-sm')     
                        .css('width', '180px');            
                       
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
                const basePath = "<?= base_url('file/viewbyfilename/') ?>";
                
                $.ajax({
                  url: "<?= base_url('admin/candidate/view') ?>",
                  type: "POST",
                  data: { id: id },
                  dataType: "json",
                  success: function (data) {
                    console.log(data.data.fullname);
                    if (data.response === 'success') {      
                      console.log(data.data.cv);
                      $('#cv_preview').attr('src', basePath + data.data.cv);
                      $('#diploma_preview').attr('src', basePath + data.data.diploma);
                      $('#transcript_preview').attr('src', basePath + data.data.transcript);
                      $('#coverletter_preview').attr('src', basePath + data.data.coverletter);
          
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

              function fn_cancel() {
                $('#editcandidateModal').html('');
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

              
            </script>