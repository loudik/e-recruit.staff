
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
                                <a href="index.html" class="pxp-animate"><span style="color: var(--pxpMainColor)">j</span>obster</a>
                            </div>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <nav class="pxp-nav-mobile">
                                <ul class="navbar-nav justify-content-end flex-grow-1">
                                    <li class="pxp-dropdown-header">Admin tools</li>
                                    <li class="nav-item"><a href="<?= base_url('admin/dashboard')?>"><span class="fa fa-home"></span>Dashboard</a></li>
                                    <li class="nav-item"><a href="<?= base_url('admin/profile')?>"><span class="fa fa-pencil"></span>Edit Profile</a></li>
                                    <li class="nav-item"><a href="<?= base_url('admin/newjobs')?>"><span class="fa fa-file-text-o"></span>New Job Offer</a></li>
                                    <li class="nav-item"><a href="<?= base_url('admin/managejobs')?>"><span class="fa fa-briefcase"></span>Manage Jobs</a></li>
                                    <li class="nav-item"><a href="<?= base_url('admin/candidate')?>"><span class="fa fa-user-circle-o"></span>Candidates</a></li>
                                    <li class="nav-item"><a href="<?= base_url('admin/changepw')?>"><span class="fa fa-lock"></span>Change Password</a></li>
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
                <h1>Manage Jobs</h1>
                <p class="pxp-text-light">Detailed list with all your job offers.</p>

                <div class="mt-4 mt-lg-5">
                    <div class="row justify-content-between align-content-center">
                        <div class="col-auto order-2 order-sm-1">
                            <div class="pxp-company-dashboard-jobs-bulk-actions mb-3">
                                <select class="form-select">
                                    <option>Bulk actions</option>
                                    <option>Edit</option>
                                    <option>Delete</option>
                                </select>
                                <button class="btn ms-2">Apply</button>
                            </div>
                        </div>
                        <div class="col-auto order-1 order-sm-2">
                            <div class="pxp-company-dashboard-jobs-search mb-3">
                                <div class="pxp-company-dashboard-jobs-search-search-form">
                                    <div class="input-group">
                                        <span class="input-group-text"><span class="fa fa-search"></span></span>
                                        <input type="text" class="form-control" placeholder="Search jobs...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="tblmanagejobs">
                            <thead>
                                <tr>
                                    <th style="width: 35%;">Job</th>
                                    <th style="width: 30%;">Category</th>
                                    <th style="width: 12%;">Type</th>
                                    <th style="width: 15%;">Applications</th>
                                    <th style="width: 15%;">Status</th>
                                    <th style="width: 30%;">Action</th>
                                    <!-- <th>&nbsp;</th> -->
                                </tr>
                            </thead>
                            <tbody> 
                                <?php foreach($jobs as $job): ?>
                                    <tr>
                                        <td><a href="#" class="pxp-table-link"><?= $job['jobs'] ?></a></td>
                                        <td><?= $job['category'] ?></td>
                                        <td><?= $job['type'] ?></td>
                                        <td><?= $job['applicants'] ?></td>
                                        <td><span class="pxp-status pxp-status-active">Active</span></td>
                                        <td style="white-space: nowrap;">
                                            <button title="Edit" class="btn btn-sm btn-primary" onclick="fn_editJob('<?= $job['id']; ?>')"><span class="fa fa-pencil"></span> </button>
                                            <!-- <button title="Preview" class="btn btn-sm btn-info" onclick="fn_previewJob('<?= $job['id']; ?>')"><span class="fa fa-eye"></span> </button> -->
                                            <button  title="Delete" class="btn btn-sm btn-danger" onclick="fn_deleteJob('<?= $job['id']; ?>')"><span class="fa fa-trash-o"></span> </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                
                            </tbody>
                        </table>

                        <div class="row mt-4 mt-lg-5 justify-content-between align-items-center">
                            <div class="col-auto">
                                <nav class="mt-3 mt-sm-0" aria-label="Jobs list pagination">
                                    <ul class="pagination pxp-pagination">
                                        <li class="page-item active" aria-current="page">
                                            <span class="page-link">1</span>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="col-auto">
                                <a href="#" class="btn rounded-pill pxp-section-cta mt-3 mt-sm-0">Show me more<span class="fa fa-angle-right"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="editJobModal" tabindex="-1" aria-labelledby="editJobModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <!-- <div class="modal-body"> -->
                        <div class="pxp-dashboard-content-details">
                            <h1>Edit Job Offer</h1>
                            <p class="pxp-text-light">Edit an existing job in your company's job listings.</p>
                            <form>
                                <div class="row mt-4 mt-lg-5">
                                    <div class="col-xxl-6">
                                        <div class="mb-3">
                                          <input type="hidden" id="jobid" name="jobid" value="<?= $job['id']; ?>" />
                                            <label for="jobs" class="form-label">Job title</label>
                                            <input type="text" id="jobs" name="jobs" class="form-control" placeholder="Edit title">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xxl-3">
                                        <label for="location" class="form-label">Location</label>
                                        <input type="text" id="location" name="location" class="form-control" placeholder="City 8, Canossa Has Laran">
                                    </div>
                                    <div class="col-md-6 col-xxl-3">
                                        <div class="mb-3">
                                            <label for="category" class="form-label">Category</label>
                                            <select id="category" class="form-select">
                                                <option>Select a category</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-xxl-3">
                                        <div class="mb-3">
                                            <label for="experience" class="form-label">Experience</label>
                                            <input type="text" id="experience" class="form-control" placeholder="E.g. Minimum 3 years">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xxl-3">
                                        <div class="mb-3">
                                            <label for="level" class="form-label">Career level</label>
                                            <select id="level" name="level" class="form-select">
                                                <option value="No Experience">No Experience</option>
                                                <option value="Entry-level">Entry-Level</option>
                                                <option value="Mid-Level">Mid-Level</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xxl-3">
                                        <div class="mb-3">
                                            <label for="type" class="form-label">Employment type</label>
                                            <select id="type" class="form-select">
                                                <option value="Full Time">Full Time</option>
                                                <option value="Part Time">Part Time</option>
                                                <option value="Remote">Remote</option>
                                                <option value="Internship">Internship</option>
                                                <option value="Contract">Contract</option>
                                                <option value="Training">Training</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xxl-3">
                                        <div class="mb-3">
                                            <label for="applicants" class="form-label">Applicants</label>
                                            <input type="text" id="applicants" class="form-control" placeholder="E.g. 3+">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xxl-3">
                                        <div class="mb-3">
                                            <label for="applydate" class="form-label">Date Apply</label>
                                            <input type="date" id="applydate" name="applydate" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xxl-3">
                                        <div class="mb-3">
                                            <label for="dateexpire" class="form-label">Date Expire</label>
                                            <input type="date" id="dateexpire" name="dateexpire" class="form-control">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="jobdescription" class="form-label">Job description</label>
                                        <textarea class="form-control" id="jobdescription" name="jobdescription" placeholder="Type the description here..."></textarea>
                                    </div>

                                    <div class="mt-4 mt-lg-5">
                                      <button type="button" class="btn rounded-pill pxp-section-cta" onclick="fn_publish()">Update Job</button>
                                      <button type="button" class="btn rounded-pill pxp-section-cta-o ms-3" data-bs-dismiss="modal" aria-label="Close">Cancel</button>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                  <!-- </div> -->
                </div>
            </div>

            <!-- Modal Sign in-->

            <div class="modal fade pxp-user-modal" id="pxp-signin-modal" aria-hidden="true" aria-labelledby="signinModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="pxp-user-modal-fig text-center">
                                <img src="images/signin-fig.png" alt="Sign in">
                            </div>
                            <h5 class="modal-title text-center mt-4" id="signinModal">Welcome back!</h5>
                            <form class="mt-4">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="email" placeholder="Email address">
                                    <label for="pxp-signin-email">Email address</label>
                                    <span class="fa fa-envelope-o"></span>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="password" placeholder="Password">
                                    <label for="pxp-signin-password">Password</label>
                                    <span class="fa fa-lock"></span>
                                </div>
                                <button type="button" class="btn rounded-pill pxp-section-cta" onclick="fn_login()">Save</button>
                                <div class="mt-4 text-center pxp-modal-small">
                                    <a href="#" class="pxp-modal-link">Forgot password</a>
                                </div>
                                <div class="mt-4 text-center pxp-modal-small">
                                    New to Jobster? <a role="button" class="" data-bs-target="#pxp-signup-modal" data-bs-toggle="modal" data-bs-dismiss="modal">Create an account</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
   

            <?= view('layoutAdmin/footer.php'); ?>

             <script type="text/javascript"> 
              

                $(document).ready(function() {
                    $('#tblmanagejobs').DataTable({
                        "processing": true,
                        "serverSide": true
                    });
                });

                function fn_editJob(id) {
                    $('#editJobModal').modal('show');

                    $.ajax({
                        url: '<?= base_url('admin/managejobs/editjobs') ?>',
                        type: 'POST',
                        data: { id: id },
                        success: function(response) {
                         
                            if (response.response === 'success') {
                                let job = response.data;
                                // console.log(job);
                                let categories = response.categories;
                                // Populate the job data in the form
                                $('#jobs').val(job.jobs);
                                $('#location').val(job.loc);
                                $('#experience').val(job.experiences);
                                $('#level').val(job.level);
                                $('#type').val(job.type);
                                $('#applicants').val(job.applicants);
                                $('#jobdescription').val(job.jobdescription);

                                function formatDate(date) {
                                    let d = new Date(date);
                                    let day = ("0" + d.getDate()).slice(-2);
                                    let month = ("0" + (d.getMonth() + 1)).slice(-2);
                                    let year = d.getFullYear();
                                    return `${year}-${month}-${day}`;
                                }

                                $('#applydate').val(formatDate(job.applydate)); 
                                $('#dateexpire').val(formatDate(job.dateexpire)); 

                                let selectedCategory = job.idunit; 
                                let id = job.category;
                                
                                let options = '<option>Select a category</option>';
                                categories.forEach(function(cat) {
                                    options += `<option value="${cat.id}" ${cat.id === selectedCategory ? 'selected' : ''}>${cat.unitname}</option>`;
                                });

                                // Update the category dropdown
                                $('#category').html(options);

                                // Trigger change to update any related UI
                                $('#category').trigger('change');
                            } else {
                                alert('Job data not found.');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', error);
                        }
                    });
                }


                function fn_publish(){

                    let id = $('#jobid').val();
                    // console.log(id);
                    let jobs = $('#jobs').val();
                    let location = $('#location').val();
                    let category = $('#category').val();
                    let jobdescription = $('#jobdescription').val();  
                    let experience = $('#experience').val();
                    let level = $('#level').val();
                    let type = $('#type').val();
                    let applicants = $('#applicants').val();
                    let applydate = $('#applydate').val();
                    let dateexpire = $('#dateexpire').val();
                    let data = {
                        id: id,
                        jobs: jobs,
                        location: location,
                        category: category,
                        jobdescription: jobdescription,
                        experience: experience,
                        level: level,
                        type: type,
                        applicants: applicants,
                        applydate: applydate,
                        dateexpire: dateexpire
                    };
                    $.ajax({
                        url: '<?= base_url('admin/managejobs/updatejobs') ?>',
                        type: 'POST',
                        data: data,
                        success: function(response) {
                            if (response.response === 'success') {
                                alert('Job updated successfully!');
                                $('#editJobModal').modal('hide');
                                window.location.href = "<?= base_url('admin/managejobs') ?>";
                            } else {
                                alert('Failed to update job.');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', error);
                        }
                    });
                }



                

                function fn_deleteJob(id) {
                  if (confirm("Are you sure you want to delete this job?")) {
                      $.ajax({
                          url: '<?= base_url('admin/managejobs/deleteJob') ?>', 
                          type: 'POST',
                          data: { id: id },
                          success: function(response) {
                              if (response.response === 'success') {
                                  alert('Job deleted successfully');
                                  // Reload the page or update the UI as needed
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
